<?php

declare(strict_types=1);

namespace App\Http\Requests\Interfaces;

interface RequestInterface
{
    /**
     * Verify this request is authorised
     */
    public function authorize(): bool;

    /**
     * Get rules to validate request.
     *
     * @return mixed[]
     */
    public function rules(): array;
}
