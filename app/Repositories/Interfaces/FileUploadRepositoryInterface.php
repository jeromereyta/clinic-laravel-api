<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\FileUpload;
use App\Services\FileUpload\Resources\CreateFileUploadResource;

interface FileUploadRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreateFileUploadResource $resource): FileUpload;

    public function findById(int $id): FileUpload;

    public function countToday(): int;
}
