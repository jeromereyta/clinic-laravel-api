<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Procedure;
use App\Database\Entities\ProcedureQueue;
use App\Enum\ProcedureQueueTypeEnum;
use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;

interface ProcedureQueueRepositoryInterface
{
    /**s
     * @return mixed[]
     */
    public function all(): array;

    public function create(CreateProcedureQueueResource $resource): void;

    public function cancelledPastDated(string $date): void;

    public function findById(int $id): ProcedureQueue;

    public function findLatestQueueNumber(): ?int;

    public function findNextProcedureQueue(Procedure $procedure, int $queueNumber): array;

    public function findWithQueues(): array;

    public function updateStatus(ProcedureQueue $procedureQueue, ProcedureQueueTypeEnum $status): void;

    public function updateQueueNumber(ProcedureQueue $procedureQueue, int $queueNumber): void;
}
