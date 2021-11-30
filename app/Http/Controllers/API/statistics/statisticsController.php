<?php

namespace App\Http\Controllers\API\statistics;

use Carbon\Carbon;
use App\Models\User;
use App\Models\products;
use App\Models\attendance;
use App\Models\Memberships;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\members_extra_information;

class statisticsController extends Controller
{
    public function index(){

        $membership = Memberships::all();
        $membershipsMemberNumber = [];

        foreach ($membership as $k => $v){


            $membershipsMemberNumber[] = [ $v['name'] => count(members_extra_information::where('membership_id','=',$v['id'])->get())];
        }

        $membersNumber = members_extra_information::all();
        $membersNumber = count($membersNumber);

        $staffNumber  =  User::role('staff')->get();
        $staffNumber  = count($staffNumber);

        $productsNumber = products::all();
        $productsNumber = count($productsNumber);

        $date = Carbon::now('Africa/Cairo')->toDateString();
        $attendanceTodayNumber = count(attendance::whereDate('come_dateTime','=',$date)->get());



        $memeberMalNumber = ['male' => count(members_extra_information::where('gender','male')->get())];
        $memeberfemaleNumber = ['female' => count(members_extra_information::where('gender','female')->get())];










        return response()->json([
            'success' => true,
            'MembershipsStatistics' => $membershipsMemberNumber,
            'membersNumbers' => $membersNumber ,
            'staffNumber' => $staffNumber,
            'products'    => $productsNumber,
            'gender'   =>  [$memeberMalNumber,$memeberfemaleNumber],
            'attendanceToday' => $attendanceTodayNumber
         ]);


    }
}
