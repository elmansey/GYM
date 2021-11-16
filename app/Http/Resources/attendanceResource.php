<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class attendanceResource extends JsonResource
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
            'user_id' => $this->user_id,
            'date' => $this->date,
            'come_time' => $this->come_time,
            'leave_time' => $this->leave_time,
            'userRelation' => $this->userRelation,
            'status' => $this->status,
        ];
    }
}
