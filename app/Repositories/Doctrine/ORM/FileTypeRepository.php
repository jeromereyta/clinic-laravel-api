<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\FileType;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class FileTypeRepository extends AbstractRepository implements FileTypeRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return FileType::class;
    }

    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('ft')
            ->from($this->getEntityClass(), 'ft')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreateFileTypeResource $resource): FileType
    {
        $fileType = new FileType();

        $fileType->fill([
            'name' => $resource->getName(),
            'description' => $resource->getDescription(),
            'type' => $resource->getType()
        ]);

        $this->entityManager->persist($fileType);
        $this->entityManager->flush();

        return $fileType;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): FileType
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('ft')
            ->from($this->getEntityClass(), 'ft')
            ->where('ft.id = :id')
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
    public function deleteFileType(FileType $fileType): void
    {
        $this->entityManager->remove($fileType);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateFileType(FileType $fileType, CreateFileTypeResource $resource): FileType
    {
        $fileType->setDescription($resource->getDescription())
            ->setName($resource->getName())
            ->setDescription($resource->getDescription())
            ->setType($resource->getType());

        $this->entityManager->persist($fileType);
        $this->entityManager->flush();

        return $fileType;
    }
}
