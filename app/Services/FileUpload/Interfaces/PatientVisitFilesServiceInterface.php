<?php

declare(strict_types=1);

namespace App\Services\FileUpload\Interfaces;

use App\Database\Entities\PatientVisit;

interface PatientVisitFilesServiceInterface
{
    /**
     * @return mixed[]
     */
    public function getPatientVisitFiles(PatientVisit  $patientVisit): array;
}
