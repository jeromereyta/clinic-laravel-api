<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientProcedure;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;

interface PatientProcedureRepositoryInterface
{
    /**
     * @return mixed[]
     */
    public function createPatientProcedures(CreatePatientProcedureResource $resource): array;

    public function findByPatient(Patient $patient): array;
}
