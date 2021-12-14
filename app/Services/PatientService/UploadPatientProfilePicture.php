<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use Illuminate\Http\UploadedFile;
use App\Services\PatientService\Interfaces\UploadPatientProfilePictureInterface;

final class UploadPatientProfilePicture implements UploadPatientProfilePictureInterface
{
    /**
     * @var string
     */
    private const FOLDER = 'patient-images';

    public function upload(UploadedFile $file): array
    {
        $image_uploaded_path = $file->store(self::FOLDER, 'public');

        return array(
            "image_name" => \sprintf('storage/patient-images/%s',basename($image_uploaded_path)),
            "mime" => $file->getClientMimeType()
        );
    }
}
