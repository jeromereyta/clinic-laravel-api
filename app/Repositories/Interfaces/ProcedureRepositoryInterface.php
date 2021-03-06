<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\CategoryProcedure;
use App\Database\Entities\Procedure;
use App\Services\Procedure\Resources\CreateProcedureResource;

interface ProcedureRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreateProcedureResource $resource): Procedure;

    public function deleteProcedure(Procedure  $procedure);

    public function findByName(string $name): ?array;
    /**
     * @return mixed[]
     */
    public function findByProcedureIds(array $procedure_ids): array;

    public function findWithQueues(): array;

    public function findById(int $id): Procedure;

    public function updateProcedure(Procedure $procedure, CreateProcedureResource $resource): Procedure;
}
