<?php

declare(strict_types=1);

namespace App\Services\PatientService\Interfaces;

use App\Database\Entities\Patient;
use App\Services\PatientService\Resources\CreatePatientResource;

interface CreatePatientServiceInterface
{
    public function create(CreatePatientResource $resource): Patient;
}
