<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientProcedure;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class PatientProcedureRepository extends AbstractRepository implements PatientProcedureRepositoryInterface
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     *
     * @return mixed[]
     */
    public function createPatientProcedures(CreatePatientProcedureResource $resource): array
    {
        $results = [];

        foreach ($resource->getProcedures() as $procedure)
        {
            $patientProcedure = new PatientProcedure();

            $patientProcedure->fill([
                'patientVisit' => $resource->getPatientVisit(),
                'procedure' => $procedure,
                'createdBy' => $resource->getCreatedBy(),
            ]);

            $this->entityManager->persist($patientProcedure);
            $this->entityManager->flush();

            $results[] = $patientProcedure;
        }

        return $results;
    }

    public function findByPatient(Patient $patient): array
    {

    }

    protected function getEntityClass(): string
    {
        return PatientProcedure::class;
    }
}
