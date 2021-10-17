<?php

declare(strict_types=1);

namespace App\Services\PatientService\Interfaces;

use App\Database\Entities\PatientVisit;
use App\Services\PatientService\Resources\CreatePatientVisitResource;

interface CreatePatientVisitServiceInterface
{
    public function create(CreatePatientVisitResource $resource): PatientVisit;
}
