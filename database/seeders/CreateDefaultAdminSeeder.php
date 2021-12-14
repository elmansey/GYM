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

        $owner = User::create([


            'name' => 'geexar',
            'user_name' => 'geexar',
            'email' => 'geexar@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581',
            'RF_code' => '12-3456-e-1234',


        ]);

        $owner->assignRole(['id' => 1, 'name' => 'owner']);


        $dataQR =  $owner['Personal_uuid'];
        $QRName = 'profile_QR/' . md5($owner['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile($QRName)->png();
        $update = User::find($owner->id);
        $update->update(['qr_code' =>  $QRName]);






        $staff = User::create([


            'name' => 'staff one',
            'user_name' => ' test staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581',
            'RF_code' => '33-q130-e-1234',



        ]);

        $staff->assignRole(['id' => 3, 'name' => 'staff']);

        $dataQR =  $staff['Personal_uuid'];
        $QRName = 'profile_QR/' . md5($staff['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile($QRName)->png();
        $update = User::find($staff->id);
        $update->update(['qr_code' =>  $QRName]);



        $staff = User::create([


            'name' => 'admin one',
            'user_name' => ' test admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581',
            'RF_code' => '335285-q130-e-1234',



        ]);

        $staff->assignRole(['id' => 2, 'name' => 'admin']);

        $dataQR =  $staff['Personal_uuid'];
        $QRName = 'profile_QR/' . md5($staff['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile($QRName)->png();
        $update = User::find($staff->id);
        $update->update(['qr_code' =>  $QRName]);
        #############################################






        // #####################################################





    }
}
