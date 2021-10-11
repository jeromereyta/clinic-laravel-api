<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use EonX\EasyRepository\Interfaces\DatabaseRepositoryInterface;
use EonX\EasyRepository\Interfaces\PaginatedObjectRepositoryInterface;

interface AppRepositoryInterface extends DatabaseRepositoryInterface
{
    /**
     * @var string
     */
    public const DATETIME_DB_FORMAT = 'Y-m-d H:i:s';

    public function findOneAndLock(string $id, int $lockMode, ?int $lockVersion = null): ?object;

    /**
     * Find one by criteria.
     *
     * @param mixed[] $criteria
     */
    public function findOneBy(array $criteria): ?object;

    public function findOneByIdAndProviderIdOrFail(string $entityId, string $providerId): object;

    /**
     * @param string[] $entityIds
     *
     * @return object[]
     */
    public function findByIdsAndProviderId(array $entityIds, string $providerId): array;

    /**
     * Find object for given identifier, throw a not found exception if not found.
     *
     * @param int|string $identifier

     * @throws \App\Exceptions\EntityNotFoundException If entity not found for given identifier
     */
    public function findOrFail($identifier): object;

    /**
     * Synchronise in-memory changes to database.
     */
    public function flush(): void;

    /**
     * @return object[]
     */
    public function getAllByProvider(string $providerId): array;

    /**
     * Save given objects by bulks, if no bulk given it defaults to 1000.
     *
     * @param object[] $objects
     */
    public function saveBulk(array $objects, ?int $bulk = null, ?bool $clearAfterFlush = null): void;
}
