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
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('transactions')
            ->from($this->getEntityClass(), 'transactions')
            ->orderBy('transactions.id','desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateTransactionSummary $resource): TransactionSummary
    {
        $transactionSummary = new TransactionSummary();

        $transactionSummary->fill([
            'transactionCountThisDay' => $resource->getTransactionCountThisDay(),
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

    public function findLatestTransactionCountToday(): ?string
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $expr = $queryBuilder->expr();

        $dateToday = (new Carbon())->toDateString();

        $fromDate = sprintf('%s 00:00:00', $dateToday);
        $toDate = sprintf('%s 23:59:00', $dateToday);

        try {
            return (string) $queryBuilder
                    ->select($expr->max('ts.transactionCountThisDay'))
                    ->from($this->getEntityClass(), 'ts')
                    ->where('ts.createdAt  BETWEEN :fromDate and :toDate')
                    ->setParameters([
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ])
                    ->getQuery()
                    ->getSingleScalarResult() ?? null;
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
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

    public function findAllByDate(Carbon $fromDate, Carbon $toDate): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $fromDate = sprintf('%s 00:00:00', $fromDate);
        $toDate = sprintf('%s 23:59:00', $toDate);

        return $queryBuilder->select('transactions')
            ->from($this->getEntityClass(), 'transactions')
            ->where('transactions.createdAt BETWEEN :fromDate and :toDate')
            ->setParameters([
                'fromDate' => $fromDate,
                'toDate' => $toDate,
            ])
            ->orderBy('transactions.id','desc')
            ->getQuery()
            ->getResult();
    }
}
