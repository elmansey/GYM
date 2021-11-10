<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class teamRoomChatResorce extends JsonResource
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
            'from' => $this->from,
            'message' => $this->message,
            'room_id' => $this->room_id,
            'send_at' => $this->send_at,
            'relation_by_user' => $this->relationByUser,
        ];
    }
}
