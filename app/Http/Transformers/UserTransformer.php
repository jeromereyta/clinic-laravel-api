<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use App\Database\Entities\UserGuest;

class UserTransformer
{
    /**
     * @param \App\Database\Entities\UserGuest $user
     *
     * @return mixed[]
     */
    public function transform(UserGuest $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ];
    }
}
