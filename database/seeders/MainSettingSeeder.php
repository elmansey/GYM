<?php

namespace Database\Seeders;

use App\Models\setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->delete();

        $data = [
            ['key' => 'Gym_name'    ,'value' => 'vip gym'],
            ['key' => 'Gym_title'    ,'value' => 'vip'],
            ['key' => 'owner_name'   ,'value' => 'ahmad mohamed'],
            ['key' => 'email'   , 'value' => 'vipGym@gmail.com'],
            ['key' => 'phone'   ,'value' => '012863501'],
            ['key' => 'address'   ,'value' => 'Jihan Street Dakahlia'],
            ['key' => 'logo'   ,'value' => ''],
            ['key' => 'about_us'   ,'value' => '']
        ];

        $setting = DB::table('setting')->insert($data);
    }
}
