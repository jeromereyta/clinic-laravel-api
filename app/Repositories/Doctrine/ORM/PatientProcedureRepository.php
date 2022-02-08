<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\PackageProcedure;
use App\Database\Entities\Patient;
use App\Database\Entities\PatientProcedure;
use App\Database\Entities\PatientVisit;
use App\Database\Entities\Procedure;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
                'description' => $resource->getDescription(),
                'patientVisit' => $resource->getPatientVisit(),
                'procedure' => $procedure,
                'createdBy' => $resource->getCreatedBy(),
                'updatedAt' => new Carbon(),
            ]);

            $this->entityManager->persist($patientProcedure);
            $this->entityManager->flush();

            $results[] = $patientProcedure;
        }

        return $results;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     *
     * @return mixed[]
     */
    public function createPatientProceduresByPackage(CreatePatientProcedureResource $resource): array
    {
        $results = [];

        foreach ($resource->getPackageProcedures() as $packageProcedure)
        {
            $patientProcedure = new PatientProcedure();

            $procedure = $packageProcedure->getProcedure();

            $patientProcedure->fill([
                'description' => $resource->getDescription(),
                'patientVisit' => $resource->getPatientVisit(),
                'packageProcedure' => $packageProcedure,
                'procedure' => $procedure,
                'createdBy' => $resource->getCreatedBy(),
                'updatedAt' => new Carbon(),
            ]);

            $this->entityManager->persist($patientProcedure);
            $this->entityManager->flush();

            $results[] = $patientProcedure;
        }

        return $results;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deletePatientProcedure(PatientProcedure $patientProcedure): void
    {
        $this->entityManager->remove($patientProcedure);
        $this->entityManager->flush();
    }

    public function findByPatient(Patient $patient): array
    {
        // TODO: Implement findByPatientVisit() method.
    }

    protected function getEntityClass(): string
    {
        return PatientProcedure::class;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByPackageProcedureAndPatientVisit(
        PatientVisit $patientVisit,
        PackageProcedure $packageProcedure
    ): ?PatientProcedure {
        $queryBuilder = $this->manager->createQueryBuilder();

        try {
            return $queryBuilder->select('pp')
                ->from($this->getEntityClass(), 'pp')
                ->where('pp.packageProcedureId = :packageProcedureId')
                ->setParameter('packageProcedureId', $packageProcedure->getId())
                ->andWhere('pp.patientVisitId = :patientVisitId')
                ->setParameter('patientVisitId', $patientVisit->getId())
                ->getQuery()
                ->getSingleResult();
        } catch (NonUniqueResultException| NoResultException $exception) {
            return null;
        }

    }

    public function findByPatientVisit(PatientVisit $patientVisit): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pp')
            ->from($this->getEntityClass(), 'pp')
            ->where('pp.patientVisitId = :patientVisitId')
            ->setParameters([
                'patientVisitId' => $patientVisit->getId(),
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): PatientProcedure
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pp')
            ->from($this->getEntityClass(), 'pp')
            ->where('pp.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }
}
