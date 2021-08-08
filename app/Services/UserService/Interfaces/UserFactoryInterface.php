<?php

declare(strict_types=1);

namespace App\Services\UserService\Interfaces;

use App\Database\Entities\User;

interface UserFactoryInterface
{
    /**
     * @param mixed[] $data
     *
     * @throws \Exception
     */
    public function create(array $data): User;
}
