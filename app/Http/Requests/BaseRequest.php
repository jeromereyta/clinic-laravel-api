<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Interfaces\RequestInterface;

abstract class BaseRequest extends FormRequest implements RequestInterface
{
    /** @noinspection PhpMissingParentCallCommonInspection */

    /**
     * This method belongs to Symfony HttpFoundation and is not usually needed when using Laravel.
     * Instead, you may use the "input" method.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return parent::get($key, $this->json($key, $default));
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get a field from the request to a float
     */
    protected function getFloat(string $key): float
    {
        return (float) $this->get($key);
    }

    /**
     * Get a field from the request cast to an int
     */
    protected function getInt(string $key): int
    {
        return (int) $this->get($key);
    }

    /**
     * Get a field from the request cast to a string
     */
    protected function getString(string $key): string
    {
        return (string) $this->get($key);
    }

    /**
     * Use the body JSON for request validation
     *
     * @return mixed[]
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function validationData(): array
    {
        if (empty($this->json()->all()) === false) {
            return $this->json()->all();
        }

        return $this->all();
    }
}
