<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\User;
use App\Services\UserService\Resources\CreateAdminUserResource;

interface UserRepositoryInterface extends AppRepositoryInterface
{
    public function create(CreateAdminUserResource $user): User;

    public function findByEmail(string $email): ?User;
}
