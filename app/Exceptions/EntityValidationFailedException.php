<?php

declare(strict_types=1);

namespace App\Exceptions;

use EonX\EasyErrorHandler\Exceptions\ValidationException;

final class EntityValidationFailedException extends ValidationException
{
    // No body needed for now.
}
