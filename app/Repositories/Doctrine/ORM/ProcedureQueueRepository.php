<?php

declare(strict_types=1);


namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Procedure;
use App\Enum\ProcedureQueueTypeEnum;
use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;
use App\Database\Entities\ProcedureQueue;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use Carbon\Carbon;
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
            'date' => (new Carbon())->toDateString(),
            'createdBy' => $resource->getCreatedBy(),
            'patientProcedure' => $resource->getPatientProcedure(),
            'status' => $resource->getStatus()->getValue(),
            'queueNumber' => $resource->getQueueNumber(),
        ]);

        $this->entityManager->persist($procedureQueue);
        $this->entityManager->flush();
    }

    public function cancelledPastDated(string $date): void
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $queryBuilder->update($this->getEntityClass(), 'pq')
            ->where('pq.status', ':inQueueStatus')
            ->setParameter('inQueueStatus', ProcedureQueueTypeEnum::IN_QUEUE)
            ->andWhere('pq.date', ':date')
            ->setParameter('date', $date)
            ->set('pq.status', ':status')
            ->setParameter('status', ProcedureQueueTypeEnum::CANCELLED)->getQuery()
            ->execute();
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
            ->addSelect('patientVisit')
            ->addSelect('patient')
            ->from($this->getEntityClass(), 'queue')
            ->innerJoin('queue.patientProcedure', 'pp')
            ->innerJoin('pp.procedure', 'p')
            ->innerJoin('pp.patientVisit', 'patientVisit')
            ->innerJoin('patientVisit.patient', 'patient')
            ->orderBy('queue.queueNumber', 'asc')
            ->where('queue.status NOT IN (:statuses)')
            ->setParameter('statuses', [ProcedureQueueTypeEnum::CANCELLED,ProcedureQueueTypeEnum::DONE] )
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findNextProcedureQueue(Procedure $procedure, int $queueNumber): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('queue')
            ->addSelect('pp')
            ->addSelect('p')
            ->from($this->getEntityClass(), 'queue')
            ->innerJoin('queue.patientProcedure', 'pp')
            ->innerJoin('pp.procedure', 'p')
            ->orderBy('queue.queueNumber', 'asc')
            ->where('p.id = :procedure_id')
            ->andWhere('queue.status = :status')
            ->andWhere('queue.queueNumber > :queue_number')
            ->setParameters([
                'procedure_id' => $procedure->getId(),
                'queue_number' => $queueNumber,
                'status' => ProcedureQueueTypeEnum::IN_QUEUE,
            ])
            ->orderBy('queue.queueNumber')
            ->getQuery()
            ->getArrayResult();
    }

    protected function getEntityClass(): string
    {
        return ProcedureQueue::class;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): ProcedureQueue
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('pq')
            ->from($this->getEntityClass(), 'pq')
            ->where('pq.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateQueueNumber(ProcedureQueue $procedureQueue, int $queueNumber): void
    {
        $procedureQueue->setQueueNumber($queueNumber);

        $this->entityManager->persist($procedureQueue);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateStatus(ProcedureQueue $procedureQueue, ProcedureQueueTypeEnum $status): void
    {
        $procedureQueue->setStatus($status->getValue());

        $this->entityManager->persist($procedureQueue);
        $this->entityManager->flush();
    }
}
