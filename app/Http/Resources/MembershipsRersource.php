<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MembershipsRersource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'Membership_price' => $this->Membership_price,
            'Membership_Period' => $this->Membership_Period,
            'Membership_private_Features' => $this->Membership_private_Features,
        ];
    }
}
