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
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName	,
            'phone'	 => $this->phone,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'jop'	 => $this->jop,
            'notes' => $this->notes
        ];
    }
}
