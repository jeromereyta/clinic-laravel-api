<?php

declare(strict_types=1);

namespace App\Http\Resources\FileUpload;

use App\Http\Resources\Resource;

final class FileTypesResources extends Resource
{
    /**
     * @param mixed[] $fileTypes
     */
    public function __construct(array $fileTypes)
    {
        parent::__construct($fileTypes);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $fileType) {
            $results[] = new FileTypeResource($fileType);
        }

        return $results;
    }
}
