<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\SubAdmin;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();
        $this->call(ClassRoomSeeder::class);
        $this->call(AdminSeeder::class);
    }

    public function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ClassRoom::truncate();
        SubAdmin::truncate();
        Teacher::truncate();
        Admin::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
