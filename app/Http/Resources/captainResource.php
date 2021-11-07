<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class captainResource extends JsonResource
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
                'id'	=>     $this->id,
                'Personal_uuid'	=>     $this->Personal_uuid,
                'name'	=>     $this->name,
                'phone'	    =>     $this->phone,
                'email'  	=>     $this->email,
                'user_name'	=> $this->user_name,
                'profile_picture'	   =>    $this->profile_picture,
                'isActive'   =>    $this->isActive
        ];
    }
}
