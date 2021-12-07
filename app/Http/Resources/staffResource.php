<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class staffResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'Personal_uuid' => $this->Personal_uuid,
            'phone'	 => $this->phone,
            'user_name'	 => $this->user_name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture,
            'qr_code' => $this->qr_code,
            'roles'	 => $this->roles,
            'isActive'	 => $this->isActive,
        ];
    }
}
