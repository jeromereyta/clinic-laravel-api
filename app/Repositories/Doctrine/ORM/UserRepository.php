<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\UserGuest;
use App\Repositories\Interfaces\UserRepositoryInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserGuest
    {
        $query = $this->createQueryBuilder('u');

        $result = $query->where('u.email = :email')
            ->setParameters([
                'email' => $email,
            ])
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }

    protected function getEntityClass(): string
    {
        return UserGuest::class;
    }
}
