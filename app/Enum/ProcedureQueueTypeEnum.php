<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class ProcedureQueueTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const CANCELLED = 'Cancelled';

    /**
     * @var string
     */
    public const DONE = 'Done';

    /**
     * @var string
     */
    public const PROGRESS = 'In Progress';

    /**
     * @var string
     */
    public const IN_QUEUE = 'In Queue';
}
