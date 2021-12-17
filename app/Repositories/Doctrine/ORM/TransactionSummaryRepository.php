<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Database\Entities\TransactionSummary;
use App\Repositories\Interfaces\TransactionSummaryRepositoryInterface;
use App\Services\TransactionSummary\Resources\CreateTransactionSummary;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class TransactionSummaryRepository extends AbstractRepository implements TransactionSummaryRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return TransactionSummary::class;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateTransactionSummary $resource): TransactionSummary
    {
        $transactionSummary = new TransactionSummary();

        $transactionSummary->fill([
            'paymentMethod' => $resource->getPaymentMethod(),
            'remarks' => $resource->getRemarks(),
            'patientVisit' => $resource->getPatientVisit(),
            'createdBy' => $resource->getCreatedBy(),
            'totalAmount' => $resource->getTotalAmount(),
            'updatedAt' => new Carbon(),
        ]);

        $this->entityManager->persist($transactionSummary);
        $this->entityManager->flush();

        return $transactionSummary;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByTransactionSummary(int $id): ?TransactionSummary
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('ts')
            ->from($this->getEntityClass(), 'ts')
            ->where('p.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    public function findByPatient(Patient $patient): array
    {
        // TODO: Implement findByPatient() method.
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByPatientVisit(PatientVisit $patientVisit): ?TransactionSummary
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('ts')
            ->from($this->getEntityClass(), 'ts')
            ->where('p.patientVisitId = :patientVisitId')
            ->setParameters([
                'patientVisitId' => $patientVisit->getId(),
            ])
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteTransactionSummary(TransactionSummary $transactionSummary): void
    {
        $transactionSummary->setDeletedAt(new Carbon());

        $this->entityManager->persist($transactionSummary);
        $this->entityManager->flush();
    }
}
