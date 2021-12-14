<?php

declare(strict_types=1);

namespace App\Services\FileUpload\Interfaces;

use App\Database\Entities\PatientVisit;
use App\Services\FileUpload\Resources\UploadFileResource;
use Illuminate\Http\UploadedFile;

interface UploadFileServiceInterface
{
    public function upload(PatientVisit $patientVisit, UploadedFile $file, string $filename): UploadFileResource;
}
