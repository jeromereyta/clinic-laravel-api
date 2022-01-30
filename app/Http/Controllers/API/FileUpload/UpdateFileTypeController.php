<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileUpload;

use App\Database\Entities\FileType;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileUpload\UpdateFileTypeRequest;
use App\Http\Resources\FileUpload\FileTypeResource;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateFileTypeController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    public function __construct(FileTypeRepositoryInterface $fileTypeRepository) {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function __invoke(int $id, UpdateFileTypeRequest $request): JsonResource
    {
        $fileType = $this->getFileType($id);

        if ($fileType === null) {
            return $this->respondError('File type not found', Response::HTTP_NOT_FOUND);
        }

        $existingNames = [];

        if ($fileType->getName() !== $request->getName()) {
            $existingNames = $this->fileTypeRepository->findByName($request->getName());
        }

        if (\count($existingNames) > 0) {
            return $this->respondError('Existing name.');
        }

        try {
            $fileType = $this->fileTypeRepository->updateFileType(
                $fileType,
                new CreateFileTypeResource([
                    'description' => $request->getDescription(),
                    'name' => $request->getName(),
                    'type' => $request->getType(),
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

    public function getFileType(int $id): ?FileType
    {
        try {
            return $this->fileTypeRepository->findById($id);
        } catch (Throwable $exception) {
            return null;
        }
    }
}
