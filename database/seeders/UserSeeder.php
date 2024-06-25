<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = '123456'; 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $now = Carbon::now();
        DB::table('users')->insert(
            [
                [
                    'name' => 'admin',
                    'email' => 'admin@gmail.com',
                    'password' =>Hash::make('1234'),
                    'type' => '0',
                    'phone' => '912345678',
                    'address' => 'Yangon',
                    'dob' => '6.1.2001',
                    'create_user_id' => "1",
                    'updated_user_id' => "1",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Htet Htet Yan Naing',
                    'email' => 'htethtetyannaing@gmail.com',
                    'password' =>Hash::make('1234'),
                    'type' => '1',
                    'phone' => '912345678',
                    'address' => 'Mawlamyine',
                    'dob' => '6.1.2001',
                    'create_user_id' => "1",
                    'updated_user_id' => "1",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Nway Nway Eain',
                    'email' => 'nwaynwayeain@gmail.com',
                    'password' =>Hash::make('1234'),
                    'type' => '1',
                    'phone' => '912345678',
                    'address' => 'Mandalay',
                    'dob' => '6.1.2001',
                    'create_user_id' => "1",
                    'updated_user_id' => "1",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

            ]
        );
    }
}
