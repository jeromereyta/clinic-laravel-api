<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\CategoryProcedure;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Services\CategoryProcedure\Resources\CreateCategoryProcedureResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use UnexpectedValueException;

final class CategoryProcedureRepository extends AbstractRepository implements CategoryProcedureRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return CategoryProcedure::class;
    }

    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('cp')
            ->from($this->getEntityClass(), 'cp')
            ->orderBy('cp.name','asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateCategoryProcedureResource $resource): CategoryProcedure
    {
        $categoryProcedure = new CategoryProcedure();

        $categoryProcedure->fill([
            'name' => $resource->getName(),
            'description' => $resource->getDescription(),
            'type' => $resource->getType()
        ]);

        $this->entityManager->persist($categoryProcedure);
        $this->entityManager->flush();

        return $categoryProcedure;
    }

    /**
     * @throws ORMException
     */
    public function deleteCategoryProcedure(CategoryProcedure $categoryProcedure): void
    {
        $this->entityManager->remove($categoryProcedure);
        $this->entityManager->flush();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): CategoryProcedure
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('cp')
            ->from($this->getEntityClass(), 'cp')
            ->where('cp.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    public function findByName(string $name): ?array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('cp')
                ->from($this->getEntityClass(), 'cp')
                ->where('cp.name = :name')
                ->setParameters([
                    'name' => $name,
                ])
                ->getQuery()
                ->getArrayResult() ?? null;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateCategoryProcedure(CategoryProcedure $categoryProcedure, CreateCategoryProcedureResource $resource): CategoryProcedure
    {
        $categoryProcedure->setName($resource->getName())
            ->setType($resource->getType())
            ->setDescription($resource->getDescription());

        $this->entityManager->persist($categoryProcedure);
        $this->entityManager->flush();

        return $categoryProcedure;
    }
}
