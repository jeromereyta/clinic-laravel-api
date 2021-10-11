<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Exceptions\EntityNotFoundException;
use App\Repositories\Interfaces\AppRepositoryInterface;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractDoctrineOrmRepository;
use Throwable;

abstract class AbstractRepository extends AbstractDoctrineOrmRepository implements AppRepositoryInterface
{
    /**
     * @param string[] $entityIds
     *
     * @return object[]
     *
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function findByIdsAndProviderId(array $entityIds, string $providerId): array
    {
        if (empty($entityIds) === true) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('e');

        $meta = $this->manager->getClassMetadata($this->getEntityClass());

        $identifier = $meta->getSingleIdentifierFieldName();

        return $queryBuilder
            ->where($queryBuilder->expr()->in(\sprintf('e.%s', $identifier), ':ids'))
            ->andWhere('e.provider = :providerId')
            ->setParameters([
                'ids' => $entityIds,
                'providerId' => $providerId,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findOneAndLock(string $id, int $lockMode, ?int $lockVersion = null): ?object
    {
        return $this->repository->find($id, $lockMode, $lockVersion);
    }

    /**
     * Find one by criteria.
     */
    public function findOneBy(array $criteria): ?object
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function findOneByIdAndProviderIdOrFail(string $entityId, string $providerId): object
    {
        $meta = $this->manager->getClassMetadata($this->getEntityClass());

        $identifier = $meta->getSingleIdentifierFieldName();

        return $this->findOneByOrFail([
            $identifier => $entityId,
            'provider' => $providerId,
        ]);
    }

    public function findOrFail($identifier): object
    {
        $entity = parent::find($identifier);

        if ($entity !== null) {
            return $entity;
        }

        throw $this->entityNotFoundException([
            'id' => $identifier,
        ]);
    }

    /**
     * Synchronise in-memory changes to database.
     */
    public function flush(): void
    {
        $this->manager->flush();
    }

    /**
     * @return object[]
     */
    public function getAllByProvider(string $providerId): array
    {
        return $this->repository->findBy([
            'provider' => $providerId,
        ]);
    }

    /**
     * Save given objects by bulks, if no bulk given it defaults to 1000.
     *
     * @throws Throwable
     */
    public function saveBulk(array $objects, ?int $bulk = null, ?bool $clearAfterFlush = null): void
    {
        $clearAfterFlush = $clearAfterFlush ?? false;
        $bulk = $bulk ?? 1000;
        $count = \count($objects);

        if ($bulk > $count) {
            $bulk = $count;
        }

        $exception = null;
        $index = 0;

        do {
            $bulkContent = [];
            while (\count($bulkContent) < $bulk && isset($objects[$index])) {
                $bulkContent[] = $objects[$index];
                $index++;
            }

            try {
                parent::save($bulkContent);
            } catch (\Throwable $exceptionThrown) {
                $exception = $exceptionThrown;
            }

            $this->manager->flush();

            if ($clearAfterFlush === true) {
                $this->manager->clear($this->getEntityClass());
            }
        } while ($index < $count);

        if ($exception !== null) {
            throw $exception;
        }
    }

    /**
     * Create entity not found exception.
     */
    protected function entityNotFoundException(array $attributes, ?string $entityClass = null): EntityNotFoundException
    {
        $attributesAsString = [];

        foreach ($attributes as $name => $value) {
            $attributesAsString[] = \sprintf('%s: %s', $name, $value);
        }

        $exception = new EntityNotFoundException('exceptions.entity.not_found');
        $exception
            ->setUserMessage('exceptions.entity.not_found')
            ->setUserMessageParams([
                'entity_class' => $entityClass ?? $this->getEntityClass(),
                'attributes' => \join(', ', $attributesAsString),
            ]);

        return $exception;
    }

    /**
     * Find one by criteria or fail.
     *
     * @throws \App\Exceptions\EntityNotFoundException
     */
    protected function findOneByOrFail(array $criteria): object
    {
        $entity = $this->repository->findOneBy($criteria);

        if ($entity !== null) {
            return $entity;
        }

        throw $this->entityNotFoundException($criteria);
    }
}
