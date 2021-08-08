<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Traits\ValidationExceptionTrait;
use App\Interfaces\Exceptions\ValidationExceptionInterface;
use Exception;

abstract class ValidationException extends Exception implements ValidationExceptionInterface
{
    use ValidationExceptionTrait;

    /**
     * @var string
     */
    protected $userMessage = 'exceptions.not_valid';
}
