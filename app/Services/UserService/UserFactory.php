<?php

declare(strict_types=1);

namespace App\Services\UserService;

use App\Database\Entities\UserGuest;
use App\Services\UserService\Interfaces\UserFactoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Hashing\HashManager;

final class UserFactory implements UserFactoryInterface
{
    public function __construct(EntityManagerInterface $entityManager, HashManager $hash)
    {
        $this->entityManager = $entityManager;
        $this->hash = $hash;
    }

    /**
     * @param \App\Services\UserService\Resources\CreateAdminUserResource $user
     */
    public function create(CreateAdminUserResource $user): UserGuest
    {
        $password = $this->hash->make($user->getPassword());

        $newUser = new UserGuest();

        $newUser->fill([
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $password,
            'type' => $user->getUserType(),
        ]);

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();

        return $newUser;
    }
}
