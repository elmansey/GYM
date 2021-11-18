<?php

namespace App\Http\Controllers\API\setting;

use App\Models\setting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class settingController extends Controller
{

    public function index (){

        $allSetting = setting::all();


        $handelSetting['setting'] = $allSetting->flatMap(function($item){

            return [$item->key  => $item->value];
        }) ;

        return response()->json(['success' => true , 'setting' => $handelSetting]);

    }



    public function update(Request $request){

        $setting = $request->all() ;

        if($request->file('logo')){

            $file = $request->file('logo');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('app_setting'),$fileName);
            $setting['logo'] = $fileName;

        }else{

            $setting = Arr::except($setting,array('logo'));
        }



        foreach ($setting as $key => $value){



             setting::where('key','=',$key)->update(['value' => $value]);

        }

        return response()->json(['success' => true , 'message' => 'setting update successfully']);
    }
}
