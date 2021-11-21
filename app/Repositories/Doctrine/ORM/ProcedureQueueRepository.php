<?php

declare(strict_types=1);


namespace App\Repositories\Doctrine\ORM;

use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;
use App\Database\Entities\ProcedureQueue;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class ProcedureQueueRepository extends AbstractRepository implements ProcedureQueueRepositoryInterface
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateProcedureQueueResource $resource): void
    {
        $procedureQueue = new ProcedureQueue();

        $procedureQueue->fill([
            'createdBy' => $resource->getCreatedBy(),
            'patientProcedure' => $resource->getPatientProcedure(),
            'status' => $resource->getStatus()->getValue(),
            'queueNumber' => $resource->getQueueNumber(),
        ]);

        $this->entityManager->persist($procedureQueue);
        $this->entityManager->flush();
    }

    public function deleteAll(): void
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $queryBuilder->delete($this->getEntityClass(), 'pq')
        ->getQuery()->getResult();
    }

    public function findLatestQueueNumber(): ?int
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $expr = $queryBuilder->expr();

        try {
            $latest_id = $queryBuilder
                    ->select($expr->max('pq.queueNumber'))
                    ->from($this->getEntityClass(), 'pq')
                    ->getQuery()
                    ->getSingleScalarResult();

            return (int) $latest_id ?? 1;
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }

    public function findWithQueues(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('queue')
            ->addSelect('pp')
            ->addSelect('p')
            ->from($this->getEntityClass(), 'queue')
            ->innerJoin('queue.patientProcedure', 'pp')
            ->innerJoin('pp.procedure', 'p')
            ->orderBy('queue.queueNumber', 'asc')
            ->getQuery()
            ->getResult();
    }

    protected function getEntityClass(): string
    {
        return ProcedureQueue::class;
    }
}
