<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(CreateAdminUserResource $user): User
    {
        $newUser = new User();

        $newUser->fill([
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword(),
            'type' => $user->getUserType(),
        ]);

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();

        return $newUser;
    }

    public function findByEmail(string $email): ?User
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
        return User::class;
    }
}
