<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'User'],
            ['id' => 3, 'name' => 'Receptionist'],
            ['id' => 4, 'name' => 'Clerk'],
            ['id' => 5, 'name' => 'Doctor'],
            ['id' => 6, 'name' => 'Nurse'],
        ]);
    }
}
