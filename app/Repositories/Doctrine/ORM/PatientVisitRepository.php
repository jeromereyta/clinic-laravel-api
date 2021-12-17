<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientVisitResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class PatientVisitRepository extends AbstractRepository implements PatientVisitRepositoryInterface
{
    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pq')
            ->from($this->getEntityClass(), 'pq')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed[]
     */
    public function allWithPatientVisits(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $dateToday = (Carbon::now())->toDateString();

        return $queryBuilder->select('pv')
            ->addSelect('p')
            ->from($this->getEntityClass(), 'pv')
            ->innerJoin('pv.patient', 'p', 'pv.patient_id = p.id')
            ->where('pv.createdAt > :dateToday')
            ->setParameter('dateToday', $dateToday)
            ->orderBy('pv.createdAt', 'asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
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
            'updatedAt' => new Carbon(),
        ]);

        $this->entityManager->persist($patientVisit);
        $this->entityManager->flush();

        return $patientVisit;
    }

    public function findByPatient(Patient $patient): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pv')
            ->addSelect('fu')
            ->from($this->getEntityClass(), 'pv')
            ->leftJoin('pv.fileUploads', 'fu', 'pv.id = fu.patient_visit_id')
            ->where('pv.patientId = :patientId')
            ->setParameters([
                'patientId' => $patient->getId(),
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByPatientVisit(int $patient_visit_id): ?PatientVisit
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pv')
            ->addSelect('fu')
            ->from($this->getEntityClass(), 'pv')
            ->leftJoin('pv.fileUploads', 'fu', 'pv.id = fu.patient_visit_id')
            ->where('pv.id = :patient_visit_id')
            ->setParameters([
                'patient_visit_id' => $patient_visit_id,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    protected function getEntityClass(): string
    {
        return PatientVisit::class;
    }
}
