<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class UserTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const ADMIN = 'admin';

    /**
     * @var string
     */
    public const CASHIER = 'cashier';

    /**
     * @var string
     */
    public const RECEPTIONIST = 'receptionist';

    /**
     * @var string
     */
    public const STAFF = 'staff';
}
