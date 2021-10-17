<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\User;
use App\Database\Entities\UserGuest;

interface UserGuestRepositoryInterface extends AppRepositoryInterface
{
    public function findByUser(User $user): ?UserGuest;
}
