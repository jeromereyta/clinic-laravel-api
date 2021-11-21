<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Http\UploadedFile;
use App\Services\PatientService\Interfaces\UploadPatientProfilePictureInterface;

final class UploadPatientProfilePicture implements UploadPatientProfilePictureInterface
{
    private const FOLDER = 'patients';

    private Factory $filesystem;

    public function __construct(Factory $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file): array
    {
        $image_uploaded_path = $file->store(self::FOLDER, 'public');

        return array(
            "image_name" => \sprintf('storage/patients/%s',basename($image_uploaded_path)),
            "mime" => $file->getClientMimeType()
        );
    }
}
