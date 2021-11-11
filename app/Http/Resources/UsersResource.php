<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id'=> $this->id,
            'name'=>$this->name,
            'user_name'=>$this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->roles,
            'profile_picture'=> $this->profile_picture,
            'Personal_uuid' => $this->Personal_uuid,
            'qr_code' => $this->qr_code,
            'messageTeamRelationTo' => $this->messageTeamRelationTo


        ];
    }
}
