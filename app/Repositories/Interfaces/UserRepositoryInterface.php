<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\UserGuest;

interface UserRepositoryInterface extends AppRepositoryInterface
{
    public function findByEmail(string $email): ?UserGuest;
}
