<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\staff;
use App\Models\Groups;
use App\Models\Memberships;
use App\Models\ClassSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\members_extra_information;
use App\Models\members_login_information;
use App\Models\members_contact_information;
use App\Models\members_personal_information;

class CreateDefaultAdminSeeder extends Seeder
{

    public function run()
    {

        DB::table('users')->delete();

        $user = User::create([


            'name' => 'test',
            'user_name' => 'user test',
            'email' => 'admin_default@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581' ,


        ]);

        $user->assignRole(['id' => 1 , 'name' => 'admin']);


        #############################################



        DB::table('staff')->delete();

        $staff = staff::create([




            'firstName'  => 'ahmad',
            'middleName'  => 'mohamed',
            'lastName'  => 'elmansey',
            'phone'  => '0102763801',
            'email'  => 'staff_default@gmail.com',
            'userName'  => 'ahmad2020',
            'password'  => bcrypt(123456),
            'isActive'  => true,



        ]);

        $staff->assignRole(['id' => 2 , 'name' => 'staff']);

        #####################################################

        // DB::table('members_personal_informations')->delete();

        // try{
        //     $member_personal = members_personal_information::create([

        //             'first_name'	 => 'saad',
        //             'middle_name'	 => 'ayman',
        //             'last_name'	 => 'saprey',
        //             'gender'	  => 'male'  ,
        //             'date_of_birth'	 => '2021-10-05',

        //     ]);

        //     $member_login = members_login_information::create([


        //             'member_id' => $member_personal->id,
        //             'user_name' => 'saad2020',
        //             'email' => 'member_default@gmail.com',
        //             'password' => bcrypt(123456),
        //             'isActive' => true,
        //     ]);

        //     $member_login->assignRole(['id' => 3 , 'name' => 'member']);



        //     $member_contact = members_contact_information::create([

        //             'member_id'     => $member_personal->id,
        //             'address'     => 'dekernes',
        //             'city'     => 'elmansora',
        //             'phone_number'     => '0102763801',
        //     ]);

        //     $member_extra = members_extra_information::create([

        //             'member_id'	       =>   $member_personal->id,
        //             'membership_id'	   =>       factory(Memberships::class, 1)->create(),
        //             'group_id'	       =>   Groups::factory(1)->create()->first(),
        //             'class_id'	       =>   ClassSchedule::factory(1)->create()->first(),
        //             'start_date'        => '2021-11-03',
        //     ]);

        // }catch(\Exception $e){

        // }


        // #####################################################





    }
}
