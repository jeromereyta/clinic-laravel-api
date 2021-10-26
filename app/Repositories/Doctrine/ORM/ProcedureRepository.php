<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\CategoryProcedure;
use App\Database\Entities\Procedure;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\CategoryProcedure\Resources\CreateCategoryProcedureResource;
use App\Services\Procedure\Resources\CreateProcedureResource;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class ProcedureRepository extends AbstractRepository implements ProcedureRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Procedure::class;
    }

    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('cp')
            ->from($this->getEntityClass(), 'cp')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateProcedureResource $resource): Procedure
    {
        $procedure = new Procedure();

        $procedure->fill([
            'active' => $resource->isActive(),
            'categoryProcedure' => $resource->getCategoryProcedure(),
            'description' => $resource->getDescription(),
            'name' => $resource->getName(),
            'price' => $resource->getPrice(),
        ]);

        $this->entityManager->persist($procedure);
        $this->entityManager->flush();

        return $procedure;
    }
}
