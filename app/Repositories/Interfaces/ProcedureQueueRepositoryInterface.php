<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;

interface ProcedureQueueRepositoryInterface
{
    /**s
     * @return mixed[]
     */
    public function all(): array;

    public function create(CreateProcedureQueueResource $resource): void;

    public function deleteAll(): void;

    public function findLatestQueueNumber(): ?int;

    public function findWithQueues(): array;
}
