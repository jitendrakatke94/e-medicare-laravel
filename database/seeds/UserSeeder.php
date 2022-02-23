<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Super',
                'middle_name' => '',
                'last_name' => 'Admin',
                'email' => 'superadmin@logidots.com',
                'password' => bcrypt('secret'),
                'username' => 'superadmin',
                'user_type' => 'SUPERADMIN',
                'is_active' => '1',
                'country_code' => '+91',
                'mobile_number' => '8610025593',
                'email_verified_at' => now(),
                'mobile_number_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate([
                'email' => $user['email']
            ], $user);
        }
    }
}
