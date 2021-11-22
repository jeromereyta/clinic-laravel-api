<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\FileType;
use App\Services\FileUpload\Resources\CreateFileTypeResource;

interface FileTypeRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreateFileTypeResource $resource): FileType;

    public function findById(int $id): FileType;
}
