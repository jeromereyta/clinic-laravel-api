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

final class DeleteFileTypeController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    public function __construct(FileTypeRepositoryInterface $fileTypeRepository) {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $fileType = $this->getFileType($id);

        if ($fileType === null) {
            return $this->respondNoContent();
        }

        try {
            $this->fileTypeRepository->deleteFileType($fileType);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
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
