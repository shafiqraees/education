<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class TeacherSeeder extends Seeder
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
                'id' => 1,
                'name' => 'test',
                'email' => 'test@user.com',
                'password' =>bcrypt('12345678'),
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Front User',
                'email' => 'user1@gmail.com',
                'password' =>bcrypt('12345678'),
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'Front User',
                'email' => 'user2@gmail.com',
                'password' =>bcrypt('12345678'),
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('teachers')->insert($users);
    }
}
