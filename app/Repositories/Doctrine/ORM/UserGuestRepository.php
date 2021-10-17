<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;


use App\Database\Entities\User;
use App\Database\Entities\UserGuest;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class UserGuestRepository extends AbstractRepository implements UserGuestRepositoryInterface
{
    public function findByUser(User $user): ?UserGuest
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $userId = $user->getUserId();

        try {
            return $queryBuilder
                ->select('ug')
                ->from($this->getEntityClass(), 'ug')
                ->where('ug.userId = :userId')
                ->setParameters([
                    'userId' => $userId,
                ])
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }

    protected function getEntityClass(): string
    {
       return UserGuest::class;
    }
}
