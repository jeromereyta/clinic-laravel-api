<?php

declare(strict_types=1);

namespace App\Interfaces\Exceptions;

interface ValidationExceptionInterface
{
    /**
     * Returns validation errors.
     *
     * @return mixed[]
     */
    public function getErrors(): array;
}
