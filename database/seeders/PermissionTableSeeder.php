<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            'show-roles-list',
            'add-role',
            'edit-role',
            'delete-role',
            'show-role-details',
            'show-team-member-list',
            'add-member-in-team',
            'edit-member-from-team',
            'delete-member-from-team',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
