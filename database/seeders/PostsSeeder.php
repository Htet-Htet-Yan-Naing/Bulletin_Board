<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('posts')->insert(
            [
                [
                    'title'=>"Title02",
                    'description'=>'Description02',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Title03",
                    'description'=>'Description03',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Title04",
                    'description'=>'Description04',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ],
                [
                    'title'=>"Title05",
                    'description'=>'Description05',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ], [
                    'title'=>"Title06",
                    'description'=>'Description0',
                    'status'=>1,
                    'create_user_id'=>1,
                    'updated_user_id'=>1,
                    'deleted_user_id'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'deleted_at'=>Carbon::now(),
                ]
             ]);
    }
}
