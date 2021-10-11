<?php

namespace Database\Seeders;

use App\Enum\UserTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('user_guests')->insert([
            'active' => true,
            'name' => 'Admin',
            'type' => UserTypeEnum::ADMIN,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('user_guests')->insert([
            'active' => true,
            'name' => 'Receptionist',
            'type' => UserTypeEnum::RECEPTIONIST,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('user_guests')->insert([
            'active' => true,
            'name' => 'Cashier',
            'type' => UserTypeEnum::CASHIER,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('user_guests')->insert([
            'active' => true,
            'name' => 'Staff',
            'type' => UserTypeEnum::STAFF,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
     }
}
