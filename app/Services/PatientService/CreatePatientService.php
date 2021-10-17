<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use App\Database\Entities\Patient;
use App\Services\PatientService\Interfaces\CreatePatientServiceInterface;
use App\Services\PatientService\Resources\CreatePatientResource;

final class CreatePatientService implements CreatePatientServiceInterface
{
    public function create(CreatePatientResource $resource): Patient
    {

    }
}
