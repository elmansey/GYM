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
use QRCode;
class CreateDefaultAdminSeeder extends Seeder
{

    public function run()
    {

        DB::table('users')->delete();

        $admin = User::create([


            'name' => 'test',
            'user_name' => 'test admin',
            'email' => 'admin_default@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581' ,
            'RF_code' => '12-3456-e-1234' ,


        ]);

        $admin->assignRole(['id' => 1 , 'name' => 'admin']);


        $dataQR =  $admin['Personal_uuid'];
        $QRName = 'profile_QR/'.md5($admin['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile(public_path($QRName))->png();
        $update = User::find($admin->id);
        $update->update(['qr_code' =>  $QRName]);



        $staff = User::create([


            'name' => 'test staff',
            'user_name' => 'user test',
            'email' => 'staff_default@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581' ,
            'RF_code' => '33-q130-e-1234' ,



        ]);

        $staff->assignRole(['id' => 2 , 'name' => 'staff']);

        $dataQR =  $staff['Personal_uuid'];
        $QRName = 'profile_QR/'.md5($staff['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile(public_path($QRName))->png();
        $update = User::find($staff->id);
        $update->update(['qr_code' =>  $QRName]);
        #############################################






        // #####################################################





    }
}
