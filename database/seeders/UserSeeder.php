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
        $now = Carbon::now();
        DB::table('users')->insert(
            [
                [
                    'name'=>"Hla Hla",
                    'email'=>'hlahla@gmail.com',
                    'password'=>'123456',
                    'profile'=>'D:\HHYN_Laravel\BulletinBoard\image\admin.jpeg',
                    'type'=>'0',
                    'phone'=>'912345678',
                    'address'=>'mandalay',
                    'dob'=>'6.1.2001',
                    'create_user_id'=>1,
                    'update_user_id'=>1,
                    'create_at'=>Carbon::now(),
                    'update_at'=>Carbon::now(),
                ],

             ]);
    }
}
