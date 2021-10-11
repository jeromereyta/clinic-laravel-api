<?php

declare(strict_types=1);

namespace App\Services\UserService\Interfaces;

use App\Database\Entities\User;
use App\Services\UserService\Resources\CreateAdminUserResource;

interface UserFactoryInterface
{
    /**
     * @param mixed[] $data
     *
     * @throws \Exception
     */
    public function create(CreateAdminUserResource $user): User;
}
