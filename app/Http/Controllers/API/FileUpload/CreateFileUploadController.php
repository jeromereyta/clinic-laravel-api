<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileUpload;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileUpload\CreateFileTypeRequest;
use App\Http\Requests\API\FileUpload\CreateFileUploadRequest;
use App\Http\Resources\FileUpload\FileTypeResource;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Repositories\Interfaces\FileUploadRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Services\FileUpload\Interfaces\UploadFileServiceInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use App\Services\FileUpload\Resources\CreateFileUploadResource;
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

    public function __construct(
        FileTypeRepositoryInterface $fileTypeRepository,
        FileUploadRepositoryInterface $fileUploadRepository,
        UploadFileServiceInterface $uploadFileService,
        PatientVisitRepositoryInterface  $patientVisitRepository
    ) {
        $this->fileTypeRepository = $fileTypeRepository;
        $this->fileUploadRepository = $fileUploadRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->uploadFileService = $uploadFileService;
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

        try {
            $rawFile = $request->file('file');

            $fileName = \sprintf(
                '%s-%s',
                $patientVisit->getPatient()->getPatientCode(),
                $rawFile->getClientOriginalName()
            );

            $file = $this->uploadFileService->upload($patientVisit, $rawFile, $fileName);

            $this->fileUploadRepository->create(
                new CreateFileUploadResource([
                    'name' => $rawFile->getClientOriginalName(),
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
