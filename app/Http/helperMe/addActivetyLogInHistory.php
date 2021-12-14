<?php

namespace App\Http\helperMe;

use App\Models\activity_logs;

trait addActivetyLogInHistory
{


    public function saveLogs($userId, $title, $date)
    {



        $activity = activity_logs::create([
            'user_id'   => $userId,
            'title'        => $title,
            'date'      => $date,
        ]);
    }
}
