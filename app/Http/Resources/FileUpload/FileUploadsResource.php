<?php

declare(strict_types=1);

namespace App\Http\Resources\FileUpload;

use App\Http\Resources\Resource;

final class FileUploadsResource extends Resource
{
    /**
     * @param mixed[] $fileUploads
     */
    public function __construct(array $fileUploads)
    {
        parent::__construct($fileUploads);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $fileUpload) {
            $results[] = new FileUploadResource($fileUpload);
        }

        return $results;
    }
}
