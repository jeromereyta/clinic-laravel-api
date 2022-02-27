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

    public function findByFirstAndLastName(string $firstName, string $lastName): ?Patient;

    public function findByPatientCode(string $patientCode): ?Patient;

    public function findLatestId(): ?string;

    public function updatePatientProfile(Patient $patient, string $profilePicture): Patient;

    public function updatePatient(Patient $patient, CreatePatientResource $resource): Patient;

}
