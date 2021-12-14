<?php

declare(strict_types=1);

namespace App\Services\FileUpload\Resources;

use App\Database\Entities\FileType;
use App\Database\Entities\PatientVisit;
use Spatie\DataTransferObject\DataTransferObject;

final class UploadFileResource extends DataTransferObject
{
    public string $filename;

    public string $path;

    public function getName(): string
    {
        return $this->filename;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setName(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
