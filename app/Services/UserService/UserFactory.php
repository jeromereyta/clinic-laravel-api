<?php

declare(strict_types=1);

namespace App\Services\UserService;

use App\Database\Entities\User;
use App\Services\UserService\Interfaces\UserFactoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Hashing\HashManager;

final class UserFactory implements UserFactoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var \Illuminate\Hashing\HashManager
     */
    private HashManager $hash;

    public function __construct(EntityManagerInterface $entityManager, HashManager $hash)
    {
        $this->entityManager = $entityManager;
        $this->hash = $hash;
    }

    public function create(CreateAdminUserResource $user): User
    {
        $password = $this->hash->make($user->getPassword());

        $newUser = new User();

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
