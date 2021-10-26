<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\CategoryProcedure;
use App\Services\CategoryProcedure\Resources\CreateCategoryProcedureResource;

interface CategoryProcedureRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreateCategoryProcedureResource $resource): CategoryProcedure;

    public function findById(int $id): CategoryProcedure;
}
