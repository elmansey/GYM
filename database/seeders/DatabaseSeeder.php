<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Factories\RoleFactory;
use Database\Seeders\MainSettingSeeder;
use Database\Seeders\default_role_Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(PermissionTableSeeder::class);
        $this->call(default_role_Seeder::class);
        $this->call(CreateDefaultAdminSeeder::class);
        $this->call(membershipsDefaultSeeder::class);
        $this->call(groupsDefaultSeeder::class);
        $this->call(MainSettingSeeder::class);
    }
}
