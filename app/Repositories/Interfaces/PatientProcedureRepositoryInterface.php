<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\PackageProcedure;
use App\Database\Entities\Patient;
use App\Database\Entities\PatientProcedure;
use App\Database\Entities\PatientVisit;
use App\Database\Entities\Procedure;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface PatientProcedureRepositoryInterface
{
    /**
     * @return mixed[]
     */
    public function createPatientProcedures(CreatePatientProcedureResource $resource): array;

    public function createPatientProceduresByPackage(CreatePatientProcedureResource $resource): array;

    public function deletePatientProcedure(PatientProcedure $patientProcedure): void;

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByPackageProcedureAndPatientVisit(
        PatientVisit $patientVisit,
        PackageProcedure $packageProcedure
    ): ?PatientProcedure;

    public function findByPatient(Patient $patient): array;

    public function findByPatientVisit(PatientVisit $patientVisit);

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): PatientProcedure;
}
