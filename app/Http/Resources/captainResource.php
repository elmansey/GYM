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
                'firstName'	 => $this->firstName,
                'middleName' => $this->middleName,
                'lastName'   => $this->lastName,
                'phone'	    =>     $this->phone,
                'email'  	=>     $this->email,
                'userName'	=> $this->userName,
                'profile_picture'	   =>    $this->profile_picture,
                'isActive'   =>    $this->isActive
        ];
    }
}
