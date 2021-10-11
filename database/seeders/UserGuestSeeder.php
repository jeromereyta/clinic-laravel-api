<?php

namespace Database\Seeders;

use App\Database\Entities\User;
use App\Database\Interfaces\UserTypes;
use App\Enum\UserTypeEnum;
use App\Services\UserService\Interfaces\UserFactoryInterface;
use App\Services\UserService\Resources\CreateAdminUserResource;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGuestSeeder extends Seeder
{
    public function __construct(UserFactoryInterface $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * @return mixed[]
     */
    public function generateUserGuests(): iterable
    {
        return [
            [
                'name' => 'Admin',
                'type' => UserTypeEnum::ADMIN,
            ],
            [
                'name' => 'Cashier',
                'type' => UserTypeEnum::CASHIER,
            ],
            [
                'name' => 'Staff',
                'type' => UserTypeEnum::STAFF,
            ],
            [
                'name' => 'Receptionist',
                'type' => UserTypeEnum::RECEPTIONIST,
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @throws \Exception
     */
    public function run(): void
    {
        $guests = $this->generateUserGuests();
        $now = Carbon::now();

        foreach ($guests as $guest) {
            $name = $guest['name'];
            $type = $guest['type'];

            $user = $this->createUser($name);

            DB::table('user_guests')->insert([
                'active' => true,
                'name' => $name,
                'type' => $type,
                'user_id' => $user->getUserId(),
                'created_at' => $now,
            ]);
        }
    }

    /**
     * @throws \Exception
     */
    private function createUser(string $name): User
    {
        $email = \sprintf('%s@testmail.com', $name);

        return $this->userFactory->create(new CreateAdminUserResource([
            'email' => $email,
            'firstName' => $name,
            'lastName' => $name,
            'password' => $name,
            'userType' => UserTypes::ADMIN,
        ]));
    }
}
