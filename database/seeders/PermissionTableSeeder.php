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
            'dashboard',
            'show-roles',
            'show-roles-list',
            'add-role',
            'edit-role',
            'delete-role',
            'show-role-details',
            'show-team',
            'show-team-member-list',
            'add-member-in-team',
            'edit-member-from-team',
            'delete-member-from-team',
            'show-memberships',
            'show-memberships-list',
            'add-membership',
            'edit-membership',
            'delete-membership',
            'show-groups',
            'show-groups-list',
            'add-group',
            'edit-group',
            'delete-group',
            'show-Registration-member',
            'show-Registration-member-list',
            'add-member-in-gym',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
