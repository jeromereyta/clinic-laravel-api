<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileUpload;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileUpload\CreateFileTypeRequest;
use App\Http\Resources\FileUpload\FileTypeResource;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class CreateFileTypeController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    public function __construct(FileTypeRepositoryInterface $fileTypeRepository) {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function __invoke(CreateFileTypeRequest $request): JsonResource
    {
        try {
            $fileType = $this->fileTypeRepository->create(
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
}
