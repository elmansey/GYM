<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class class_scheduleResourceToGetCountMember extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [

            'id'     => $this->id,
            'staffName'     => $this->staffName,
            'days'     => $this->days,
            'startingTime'     => $this->startingTime,
            'endingTime'     => $this->endingTime,
            'trainingLocation' => $this->trainingLocation,
            'group_relation' => $this->group_relation,
            'captain_relation' => $this->captain_relation,
            'group_id' => $this->group_id,
            'countMember' => $this->countMember,
        ];
    }
}
