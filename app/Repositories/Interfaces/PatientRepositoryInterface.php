<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Patient;
use App\Services\PatientService\Resources\CreatePatientResource;

interface PatientRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreatePatientResource $resource): Patient;

    public function findByPatientCode(string $patientCode): ?Patient;

    public function findLatestId(): ?string;
}
