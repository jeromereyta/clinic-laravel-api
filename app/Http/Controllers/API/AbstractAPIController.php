<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Database\Entities\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class AbstractAPIController
{
    public function getUser(): ?Authenticatable
    {
        return JWTAuth::user();
    }

    /**
     * Return HTTP OK (200) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondOk(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_OK, $headers);
    }

    /**
     * Return HTTP bad request (400) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondBadRequest(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_BAD_REQUEST, $headers);
    }

    /**
     * Return HTTP conflict (409) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondConflict(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_CONFLICT, $headers);
    }

    /**
     * Return HTTP created (201) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondCreated(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_CREATED, $headers);
    }
    /**
     * Return HTTP bad request (400) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondInternalError(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_BAD_REQUEST, $headers);
    }

    /**
     * Return HTTP forbidden (403) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondForbidden(array $data = null, array $headers = []): JsonResource
    {
        if ($data === null) {
            $data = [
                'message' => 'Invalid credentials',
            ];
        }

        return new JsonResource($data, Response::HTTP_FORBIDDEN, $headers);
    }

    /**
     * Return HTTP no content (204) response
     *
     * @param mixed[] $headers
     */
    protected function respondNoContent(array $headers = []): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT, $headers);
    }

    /**
     * Return HTTP not found (404) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondNotFound(array $data = [], array $headers = []): JsonResource
    {
        return new JsonResource($data, Response::HTTP_NOT_FOUND, $headers);
    }

    /**
     * Return HTTP unauthorized (401) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondUnauthorised(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED, $headers);
    }

    /**
     * Return HTTP unprocessable (422) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondUnprocessable(array $data = [], array $headers = []): JsonResource
    {
        return new JsonResource($data, Response::HTTP_UNPROCESSABLE_ENTITY, $headers);
    }
}
