<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserToRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'name'=>$this->name,
            'user_name'=>$this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_picture' => $this->profile_picture,
            'Personal_uuid' => $this->Personal_uuid,
            'isActive' => $this->isActive
            ];
    }
}
