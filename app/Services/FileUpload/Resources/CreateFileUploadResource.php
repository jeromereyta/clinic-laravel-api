<?php

declare(strict_types=1);

namespace App\Services\FileUpload\Resources;

use App\Database\Entities\FileType;
use App\Database\Entities\PatientVisit;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateFileUploadResource extends DataTransferObject
{
    public string $name;

    public string $path;

    public string $format;

    public string $description;

    private PatientVisit $patientVisit;

    private FileType $fileType;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPatientVisit(): PatientVisit
    {
        return $this->patientVisit;
    }

    public function getFileType(): FileType
    {
        return $this->fileType;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setPatientVisit(PatientVisit $patientVisit): self
    {
        $this->patientVisit = $patientVisit;

        return $this;
    }

    public function setFileType(FileType $fileType): self
    {
        $this->fileType = $fileType;

        return $this;
    }


}
