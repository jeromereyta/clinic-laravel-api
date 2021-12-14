<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileUpload;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\FileUpload\FileTypesResources;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class FileTypeListController extends AbstractAPIController
{
    private FileTypeRepositoryInterface $fileTypeRepository;

    public function __construct(FileTypeRepositoryInterface $fileTypeRepository) {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function __invoke(): JsonResource
    {
        return new FileTypesResources($this->fileTypeRepository->all() ?? []);
    }
}
