<?php

declare(strict_types=1);

namespace App\Database\Interfaces;

interface UserTypes
{
    /**
     * @var string[]
     */
    public const TYPES = [
        self::ADMIN,
        self::PATIENT,
        self::STAFF,
    ];

    /**
     * @var string
     */
    public const ADMIN = 'admin';

    /**
     * @var string
     */
    public const PATIENT = 'patient';

    /**
     * @var string
     */
    public const STAFF = 'staff';
}
