<?php

namespace App\Http\Controllers\API\History;

use App\Http\Controllers\Controller;
use App\Models\activity_logs;
use Illuminate\Http\Request;

class activityLogsController extends Controller
{

    public function index (){

        $history = activity_logs::with('userRelation')->orderBy('id', 'DESC')->get();


        return  response()->json(['success' => true , 'history' => $history]);


    }





}
