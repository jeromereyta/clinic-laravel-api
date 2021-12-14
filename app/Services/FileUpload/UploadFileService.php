<?php

declare(strict_types=1);

namespace App\Services\FileUpload;

use App\Database\Entities\PatientVisit;
use App\Services\FileUpload\Interfaces\UploadFileServiceInterface;
use App\Services\FileUpload\Resources\UploadFileResource;
use Illuminate\Http\UploadedFile;

final class UploadFileService implements UploadFileServiceInterface
{
    /**
     * @var string
     */
    private const FOLDER = 'patient-files';

    public function upload(PatientVisit $patientVisit, UploadedFile $file, string $filename): UploadFileResource
    {
        $path = \sprintf(
            '%s/%s',
            self::FOLDER,
            $patientVisit->getId(),
        );

        $filePath = $file->storeAs($path, $filename ,'public');

        return new UploadFileResource([
            "path" => $filePath,
            "filename" => \sprintf(
                'storage/%s/%s',
                self::FOLDER,
                basename($filePath)
            ),
        ]);
    }
}
