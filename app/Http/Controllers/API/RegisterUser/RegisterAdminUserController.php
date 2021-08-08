<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RegisterUser;

use App\Database\Entities\User;
use App\Database\Interfaces\UserTypes;
use App\Http\Controllers\API\AbstractAPIController;
use App\Services\UserService\Interfaces\UserFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

final class RegisterAdminUserController extends AbstractAPIController
{
    /**
     * @var \App\Services\UserService\Interfaces\UserFactoryInterface
     */
    protected $userFactory;

    /**
     * RegisterAdminUserController constructor.
     */
    public function __construct(UserFactoryInterface $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function __invoke(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $request->toArray();
        $email = $request->get('email');

        if ($this->checkUserByEmail($email, $entityManager) === false) {
            return $this->respondBadRequest([
                'error' => 'User is already registered.'
            ]);
        }

        $password = $user['password'];

        try {
            $user['type'] = UserTypes::ADMIN;

            $user['password'] = app('hash')->make($password);

            $newUser = $this->userFactory->create($user);

            $entityManager->persist($newUser);
            $entityManager->flush();

            $credentials = [
                'email' => $email,
                'password' => $password
            ];

            $token = JWTAuth::attempt($credentials);

            if ($token === null) {
                return $this->respondUnauthorised();
            }

            return response()->json([
                'token' => $user,
            ]);
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception,
            ]);
        }
    }

    protected function checkUserByEmail($email, EntityManagerInterface $entityManager): bool
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'email' => $email
            ]);

        return $user === null;
    }
}
