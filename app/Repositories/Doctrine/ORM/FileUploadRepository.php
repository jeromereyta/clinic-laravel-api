<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\FileType;
use App\Database\Entities\FileUpload;
use App\Repositories\Interfaces\FileUploadRepositoryInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use App\Services\FileUpload\Resources\CreateFileUploadResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class FileUploadRepository extends AbstractRepository implements FileUploadRepositoryInterface
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
    public function create(CreateFileUploadResource $resource): FileUpload
    {
        $fileUpload = new FileUpload();

        $fileUpload->fill([
            'name' => $resource->getName(),
            'description' => $resource->getDescription(),
            'path' => $resource->getPath(),
            'format' => $resource->getFormat(),
            'fileType' => $resource->getFileType(),
            'patientVisit' => $resource->getPatientVisit(),
        ]);

        $this->entityManager->persist($fileUpload);
        $this->entityManager->flush();

        return $fileUpload;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findById(int $id): FileUpload
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('fu')
            ->from($this->getEntityClass(), 'fu')
            ->where('fu.id = :id')
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getSingleResult();
    }
}
