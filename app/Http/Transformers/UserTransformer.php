<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use App\Database\Entities\User;

class UserTransformer
{
    /**
     * @param \App\Database\Entities\User $user
     *
     * @return mixed[]
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ];
    }
}
