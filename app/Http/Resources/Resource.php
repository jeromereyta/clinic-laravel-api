<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @package Rex\Http\Resources
 */
abstract class Resource extends JsonResource
{
    /**
     * Return this resource as an array
     *
     * @noinspection PhpMissingParentCallCommonInspection
     *
     * @param Request $request
     *
     * @return string[]
     */
    public function toArray($request): array
    {
        return $this->getResponse();
    }

    /**
     * @noinspection ReturnTypeCanBeDeclaredInspection
     *
     * Create an HTTP response that represents the object
     * and set the status code and return type
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return parent::toResponse($request)
            ->setStatusCode($this->getStatusCode())
            ->withHeaders([
                'Content-Type' => 'application/vnd.api+json',
            ]);
    }

    abstract protected function getResponse(): array;


    /**
     * The status code for responses generated by this resource
     */
    protected function getStatusCode(): int
    {
        return ResponseAlias::HTTP_OK;
    }
}
