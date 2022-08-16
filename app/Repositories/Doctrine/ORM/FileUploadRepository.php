<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\FileType;
use App\Database\Entities\FileUpload;
use App\Repositories\Interfaces\FileUploadRepositoryInterface;
use App\Services\FileUpload\Resources\CreateFileTypeResource;
use App\Services\FileUpload\Resources\CreateFileUploadResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class FileUploadRepository extends AbstractRepository implements FileUploadRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return FileUpload::class;
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
            'updatedAt' => new Carbon(),
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

    public function countToday(): int
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $dateToday = (new Carbon())->toDateString();

        $fromDate = sprintf('%s 00:00:00', $dateToday);
        $toDate = sprintf('%s 23:59:00', $dateToday);

        try {
            return (int) $queryBuilder
                    ->select('count(fu.id)')
                    ->from($this->getEntityClass(), 'fu')
                    ->where('fu.createdAt  BETWEEN :fromDate and :toDate')
                    ->setParameters([
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ])
                    ->getQuery()
                    ->getSingleScalarResult() ?? 0;
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
    }
}
