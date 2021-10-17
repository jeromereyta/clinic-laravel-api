<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Authentication\AdminLoginRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTAuth;

final class AdminLoginController extends AbstractAPIController
{
    private JWTAuth $jwt;

    private UserRepositoryInterface $userRepository;

    /**
     * RegisterAdminUserController constructor.
     */
    public function __construct(
        JWTAuth $jwt,
        UserRepositoryInterface $userRepository
    ) {
        $this->jwt = $jwt;
        $this->userRepository = $userRepository;
    }

    public function __invoke(AdminLoginRequest $request): JsonResponse
    {
        $email = $request->getEmail('email');

        $exist = $this->userRepository->findByEmail($email);

        if ($exist === null) {
            return $this->respondBadRequest([
                'error' => \sprintf('Invalid user, email not found %s', $email),
            ]);
        }

        try {
            $credentials = [
                'email' => $email,
                'password' => $request->getPassword(),
            ];

            $token = $this->jwt->attempt($credentials);

            if ($token === false) {
                return $this->respondUnauthorised([
                    'message' => 'Invalid credentials'
                ]);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]);
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }
}
