<?php

declare(strict_types=1);

namespace App\Exceptions;

use EonX\EasyErrorHandler\Exceptions\NotFoundException;

final class EntityNotFoundException extends NotFoundException
{
    // No body needed for now.
}
