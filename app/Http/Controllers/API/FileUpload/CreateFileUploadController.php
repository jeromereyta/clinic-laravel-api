<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileUpload;

use App\Database\Entities\Procedure;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileUpload\CreateFileTypeRequest;
use App\Http\Requests\API\FileUpload\CreateFileUploadRequest;
use App\Http\Resources\FileUpload\FileTypeResource;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Repositories\Interfaces\FileUploadRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\FileUpload\Interfaces\UploadFileServiceInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use App\Services\FileUpload\Resources\CreateFileUploadResource;
use Carbon\Carbon;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Throwable;

final class CreateFileUploadController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    private FileUploadRepositoryInterface $fileUploadRepository;

    private PatientVisitRepositoryInterface  $patientVisitRepository;

    private UploadFileServiceInterface $uploadFileService;

    private ProcedureRepositoryInterface $procedureRepository;

    public function __construct(
        FileTypeRepositoryInterface $fileTypeRepository,
        FileUploadRepositoryInterface $fileUploadRepository,
        UploadFileServiceInterface $uploadFileService,
        PatientVisitRepositoryInterface  $patientVisitRepository,
        ProcedureRepositoryInterface $procedureRepository
    ) {
        $this->fileTypeRepository = $fileTypeRepository;
        $this->fileUploadRepository = $fileUploadRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->uploadFileService = $uploadFileService;
        $this->procedureRepository = $procedureRepository;
    }

    public function __invoke(CreateFileUploadRequest $request): JsonResource
    {
        $fileType = $this->fileTypeRepository->findById($request->getFileTypeId());

        if ($fileType === null) {
            return $this->respondNotFound([
                'message' => 'File Type not found',
            ]);
        }

        $patientVisit = $this->patientVisitRepository->findByPatientVisit($request->getPatientVisitId());

        if ($patientVisit === null) {
            return $this->respondNotFound([
                'message' => 'Patient Visit not found',
            ]);
        }


        $procedure = null;


        if ($request->getProcedureId() !== null) {
            $procedure = $this->procedureRepository->findById($request->getProcedureId());
        }

        try {
            $rawFile = $request->file('file');

            $dateToday = (new Carbon())->format('mdY');

            $counter = $this->fileUploadRepository->countToday();

            $counter = $counter + 1;

            if (strlen((string) $counter) === 1) {
                $counter = sprintf('0%s', $counter);
            }

            $modifiedFilename = sprintf('%s-%s-%s%s.%s',
                $patientVisit->getPatient()->getPatientCode(),
                $dateToday,
                $procedure->getDescription(),
                $counter,
                $rawFile->getClientOriginalExtension()
            );

            $fileName = \sprintf(
                '%s-%s',
                $patientVisit->getPatient()->getPatientCode(),
                $rawFile->getClientOriginalName()
            );

            $file = $this->uploadFileService->upload($patientVisit, $rawFile, $modifiedFilename);

            $this->fileUploadRepository->create(
                new CreateFileUploadResource([
                    'name' => $modifiedFilename,
                    'description' => $request->getDescription(),
                    'path' => $file->getPath(),
                    'format' => $rawFile->getClientMimeType() ?? '',
                    'fileType' => $fileType,
                    'patientVisit' => $patientVisit,
                ])
            );

            return $this->respondNoContent();
        } catch (ORMException $ormException) {
            return $this->respondUnprocessable([
                'message' => $ormException->getMessage(),
            ]);
        } catch (Throwable $throwable) {
            return $this->respondInternalError([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
