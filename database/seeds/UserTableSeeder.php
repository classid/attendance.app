<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use CID\Finger\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $data = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'test-admin1@gmail.com',
                'password' => bcrypt('password'),
                'api_token' => bcrypt('test-admin1@gmail.com'),
            ],
        ];

        foreach ($data as $idx => $user) {
            User::create(array_merge($user, [
                'email_verified_at' => $now,
            ]));
        }
    }
}
