<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Package;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use App\Services\PackageProcedureService\Resources\CreatePackageResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class PackageRepository extends AbstractRepository implements PackageRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Package::class;
    }

    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('package')
            ->addSelect('packageProcedures')
            ->from($this->getEntityClass(), 'package')
            ->innerJoin('package.packageProcedures', 'packageProcedures')
            ->orderBy('package.name','asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreatePackageResource $resource): Package
    {
        $package = new Package();

        $package->fill([
           'name' => $resource->getName(),
           'description' => $resource->getDescription(),
        ]);

        $this->entityManager->persist($package);
        $this->entityManager->flush();

        return $package;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deletePackage(Package $package): void
    {
        $package->setDeletedAt(new Carbon());

        $this->entityManager->persist($package);
        $this->entityManager->flush();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): Package
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('p')
            ->from($this->getEntityClass(), 'p')
            ->where('p.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    public function findByName(string $name): ?array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('p')
                ->from($this->getEntityClass(), 'p')
                ->where('p.name = :name')
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
    public function updatePackage(Package $package, CreatePackageResource $resource): Package
    {
        $package->setName($resource->getName())
            ->setDescription($resource->getDescription());


        $this->entityManager->persist($package);
        $this->entityManager->flush();

        return $package;
    }
}
