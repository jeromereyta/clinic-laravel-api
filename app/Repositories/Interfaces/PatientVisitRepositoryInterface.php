<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Services\PatientService\Resources\CreatePatientVisitResource;

interface PatientVisitRepositoryInterface
{
    public function allWithPatientVisits(): array;

    public function create(CreatePatientVisitResource $resource): PatientVisit;

    public function findByPatient(Patient $patient): array;

    public function findByPatientVisit(int $patient_visit_id): ?PatientVisit;
}
