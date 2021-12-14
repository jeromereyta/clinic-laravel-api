<?php

declare(strict_types=1);

namespace App\Http\Resources\FileUpload;

use App\Database\Entities\FileType;
use App\Database\Entities\FileUpload;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class FileUploadResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
     *
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof FileUpload) === false) {
            throw new InvalidResourceTypeException(
                FileType::class,
                \get_class($this->resource)
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'description' => $this->resource->getDescription(),
            'path' => $this->resource->getPath(),
            'format' => $this->resource->getFormat(),
            'file_type_id' => $this->resource->getFileType()->getId(),
            'file_type' => new FileTypeResource($this->resource->getFileType()),
        ];
    }
}
