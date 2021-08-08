<?php

declare(strict_types=1);

namespace App\Exceptions\Traits;

trait ValidationExceptionTrait
{
    /**
     * @var mixed[]
     */
    protected $errors = [];

    /**
     * @return mixed[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Sets validation errors.
     *
     * @param mixed[] $errors
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
