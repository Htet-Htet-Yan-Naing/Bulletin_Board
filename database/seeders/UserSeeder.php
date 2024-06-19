<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '123456'; 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $now = Carbon::now();
        DB::table('users')->insert(
            [
                [
                    'name' => "admin",
                    'email' => 'admin@gmail.com',
                    'password' => $hashedPassword,
                    'profile' => '1718180619.jpg',
                    'type' => '0',
                    'phone' => '912345678',
                    'address' => 'mandalay',
                    'dob' => '6.1.2001',
                    'create_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

            ]
        );
    }
}
