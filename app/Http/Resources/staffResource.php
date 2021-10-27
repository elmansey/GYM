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
            'firstName' => $this->firstName,
            'Personal_uuid' => $this->Personal_uuid,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName	,
            'phone'	 => $this->phone,
            'userName'	 => $this->userName,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'roles'	 => $this->roles,
            'notes' => $this->notes
        ];
    }
}
