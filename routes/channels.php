<?php

use App\Models\User;
use App\Models\staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });



Broadcast::channel('chat_message.{Personal_uuid}', function ($user, $Personal_uuid) {

    return (string) $user->Personal_uuid === (string) $Personal_uuid;


},['guards' => ['auth:admin','auth:staff']]);
