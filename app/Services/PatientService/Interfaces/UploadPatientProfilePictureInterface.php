<?php

declare(strict_types=1);

namespace App\Services\PatientService\Interfaces;

use Illuminate\Http\UploadedFile;

interface UploadPatientProfilePictureInterface
{
    public function upload(UploadedFile $file): array;
}
