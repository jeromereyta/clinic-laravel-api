<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RegisterUser;

use App\Database\Interfaces\UserTypes;
use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;
use Exception;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RegisterAdminUserController extends AbstractAPIController
{
    /**
     * @var \Illuminate\Hashing\HashManager
     */
    private HashManager $hash;

    /**
     * @var \App\Repositories\Interfaces\UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * RegisterAdminUserController constructor.
     */
    public function __construct(
        HashManager $hash,
        UserRepositoryInterface $userRepository
    ) {
        $this->hash = $hash;
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

            $newUser =$this->userRepository->create(new CreateAdminUserResource([
                'email' => $email,
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'password' => $this->hash->make($user['password']),
                'userType' => UserTypes::ADMIN,
            ]));

            if ($newUser === null) {
                return $this->respondUnauthorised();
            }

            return response()->json([
                'user' => $user,
            ]);
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }
}
