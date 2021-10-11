<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RegisterUser;

use App\Database\Interfaces\UserTypes;
use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService\Interfaces\UserFactoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTAuth;

final class RegisterAdminUserController extends AbstractAPIController
{
    protected UserFactoryInterface $userFactory;

    private JWTAuth $jwt;

    private UserRepositoryInterface $userRepository;

    /**
     * RegisterAdminUserController constructor.
     */
    public function __construct(
        JWTAuth $jwt,
        UserFactoryInterface $userFactory,
        UserRepositoryInterface $userRepository
    ) {
        $this->jwt = $jwt;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->toArray();
        $email = $request->get('email');

        $exist = $this->userRepository->findByEmail($email);

        if ($exist !== null) {
            return $this->respondBadRequest([
                'error' => 'User is already registered.'
            ]);
        }

        try {
            $user['type'] = UserTypes::ADMIN;

            $newUser = $this->userFactory->create(new CreateAdminUserResource([
                'email' => $email,
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'password' => $user['password'],
                'userType' => UserTypes::ADMIN,
            ]));

            $credentials = [
                'email' => $email,
                'password' => $user['password'],
            ];

            $token = $this->jwt->attempt($credentials);

            if ($token === null) {
                return $this->respondUnauthorised();
            }

            return response()->json([
                'token' => $user,
            ]);
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }
}
