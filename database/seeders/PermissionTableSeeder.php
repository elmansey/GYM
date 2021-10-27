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
            'show-staff-list',
            'add-person-in-staff',
            'edit-person-in-staff',
            'delete-person-in-staff',
            'show-groups',
            'show-groups-list',
            'add-group',
            'edit-group',
            'delete-group',
            'show-class-schedule-all',
            'show-class_schedule-list',
            'show-class_schedule',
            'add-class-schedule',
            'edit-class-schedule',
            'edit-class-schedule-in-classSchedule',
            'delete-class-schedule',
            'show-Registration-member',
            'show-Registration-member-list',
            'add-member-in-gym',
            'show-setting',




        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
