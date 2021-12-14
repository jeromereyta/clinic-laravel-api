<?php

declare(strict_types=1);

namespace App\Services\FileUpload;

use App\Database\Entities\PatientVisit;
use App\Services\FileUpload\Interfaces\PatientVisitFilesServiceInterface;
use Illuminate\Filesystem\Filesystem;

final class PatientVisitFilesService implements PatientVisitFilesServiceInterface
{
    /**
     * @var string
     */
    public const KEY_PATH = 'storage/patient-files/%s';

    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getPatientVisitFiles(PatientVisit $patientVisit): array
    {
        $path =  public_path(
            \sprintf(
                self::KEY_PATH,
                $patientVisit->getId()
            )
        );

        $files = $this->filesystem->allFiles($path);

        foreach ($files as $file) {

        }
    }
}
