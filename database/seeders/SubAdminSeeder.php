<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubAdminSeeder extends Seeder
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
                'name' => 'Sub Adamin',
                'email' => 'subadmin@subadmin.com',
                'password' =>bcrypt('12345678'),
                'org_password' => '12345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Front User',
                'email' => 'user1@gmail.com',
                'password' =>bcrypt('12345678'),
                'org_password' => '12345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'Front User',
                'email' => 'user2@gmail.com',
                'password' =>bcrypt('12345678'),
                'org_password' => '12345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('sub_admins')->insert($users);
    }
}
