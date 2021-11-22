<?php

declare(strict_types=1);

namespace App\Http\Resources\FileUpload;

use App\Database\Entities\FileType;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class FileTypeResource extends Resource
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
        if (($this->resource instanceof FileType) === false) {
            throw new InvalidResourceTypeException(
                FileType::class,
                \get_class($this->resource)
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'description' => $this->resource->getDescription(),
            'type' => $this->resource->getType(),
        ];
    }
}
