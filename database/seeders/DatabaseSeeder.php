<?php

namespace Database\Seeders;

use Database\Factories\RoleFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
        $this->call(CreateDefaultAdminSeeder::class);
        $this->call(membershipsDefaultSeeder::class);
        $this->call(groupsDefaultSeeder::class);
    }
}
