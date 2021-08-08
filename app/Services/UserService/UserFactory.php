<?php

declare(strict_types=1);

namespace App\Services\UserService;

use App\Database\Entities\User;
use App\Services\UserService\Interfaces\UserFactoryInterface;

final class UserFactory implements UserFactoryInterface
{
    /**
     * @param mixed[] $data
     *
     * @throws \Exception
     */
    public function create(array $data): User
    {
        $user = new User();

        $user->fill($data);

        return $user;
    }
}
