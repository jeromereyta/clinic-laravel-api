<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Package;
use App\Database\Entities\PackageProcedure;
use App\Repositories\Interfaces\PackageProcedureRepositoryInterface;
use App\Services\PackageProcedureService\Resources\CreatePackageProcedureResource;
use App\Services\PackageProcedureService\Resources\UpdatePackageProcedureResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class PackageProcedureRepository extends AbstractRepository implements PackageProcedureRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return PackageProcedure::class;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreatePackageProcedureResource $resource): PackageProcedure
    {
        $packageProcedure = new PackageProcedure();

        $packageProcedure
            ->setPrice($resource->getPrice())
            ->setPackage($resource->getPackage())
            ->setProcedure($resource->getProcedure());

        $this->entityManager->persist($packageProcedure);
        $this->entityManager->flush();

        return $packageProcedure;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deletePackage(PackageProcedure $packageProcedure): void
    {
        $this->entityManager->remove($packageProcedure);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deletePackageProcedure(Package $package): void
    {
        $packageProcedures = $this->findPackageProceduresByPackage($package);

        $dateToday = new Carbon();

        foreach ($packageProcedures as $packageProcedure) {
            $model = $this->find((int) $packageProcedure['id']);
            $model->setDeletedAt($dateToday);
            $this->entityManager->persist($model);

//            $this->entityManager->remove($this->findById($packageProcedure['id']));
        }

        $this->entityManager->flush();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): PackageProcedure
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

    private function findPackageProceduresByPackage(Package $package) {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('p')
                ->from($this->getEntityClass(), 'p')
                ->where('p.packageId = :packageId')
                ->setParameters([
                    'packageId' => $package->getId(),
                ])
                ->getQuery()
                ->getArrayResult() ?? null;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updatePackageProcedure(PackageProcedure $packageProcedure, UpdatePackageProcedureResource $resource): PackageProcedure
    {
        $packageProcedure->setPrice($resource->getPrice());

        $this->entityManager->persist($packageProcedure);
        $this->entityManager->flush();

        return $packageProcedure;
    }

    public function findByPackageAndProcedure(int $packageId, int $procedureId): ?PackageProcedure
    {
        try {
            $queryBuilder = $this->manager->createQueryBuilder();

            return $queryBuilder->select('p')
                ->from($this->getEntityClass(), 'p')
                ->where('p.packageId = :packageId')
                ->andWhere('p.procedureId = :procedureId')
                ->setParameters([
                    'packageId' => $packageId,
                    'procedureId' => $procedureId,
                ])
                ->getQuery()
                ->getSingleResult();

        } catch (\Exception $exception) {
            return null;
        }
    }
}
