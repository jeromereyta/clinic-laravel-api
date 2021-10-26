<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class CategoryProcedureTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const LABORATORY = 'laboratory';

    /**
     * @var string
     */
    public const CONSULTATION = 'consultation';
}
