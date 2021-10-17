<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientVisitResource;

final class PatientVisitRepository extends AbstractRepository implements PatientVisitRepositoryInterface
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(CreatePatientVisitResource $resource): PatientVisit
    {
        $patientVisit = new PatientVisit();

        $patientVisit->fill([
            'attendingDoctor' => $resource->getAttendingDoctor(),
            'createdBy' => $resource->getCreatedBy(),
            'patient' => $resource->getPatient(),
            'patientBp' => $resource->getPatientBP(),
            'patientHeight' => $resource->getPatientHeight(),
            'patientWeight' => $resource->getPatientWeight(),
            'remarks' => $resource->getRemarks(),
        ]);

        $this->entityManager->persist($patientVisit);
        $this->entityManager->flush();

        return $patientVisit;
    }

    public function findByPatient(Patient $patient): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pv')
            ->from($this->getEntityClass(), 'pv')
            ->where('pv.patientId = :patientId')
            ->setParameters([
                'patientId' => $patient->getId(),
            ])
            ->getQuery()
            ->getResult();
    }

    protected function getEntityClass(): string
    {
        return PatientVisit::class;
    }
}
