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
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use App\Services\FileUpload\Resources\CreateFileUploadResource;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class CreateFileUploadController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    private FileUploadRepositoryInterface $fileUploadRepository;

    private PatientVisitRepositoryInterface  $patientVisitRepository;

    public function __construct(
        FileTypeRepositoryInterface $fileTypeRepository,
        FileUploadRepositoryInterface $fileUploadRepository,
        PatientVisitRepositoryInterface  $patientVisitRepository
    ) {
        $this->fileTypeRepository = $fileTypeRepository;
        $this->fileUploadRepository = $fileUploadRepository;
        $this->patientVisitRepository = $patientVisitRepository;
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
            $fileUpload = $this->fileUploadRepository->create(
                new CreateFileUploadResource([
                    'name' => $request->getName(),
                    'description' => $request->getDescription(),
                    'path' => $request->getPath(),
                    'format' => $request->getFormatFileUpload(),
                    'fileType' => $fileType,
                    'patientVisit' => $patientVisit,
                ])
            );

            return new FileTypeResource($fileType);
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
