<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class classSceduleResource extends JsonResource
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
            'group_relation' => $this->group_relation,
            'startingTime' => $this->startingTime,
            'endingTime'  =>$this->endingTime

        ];
    }
}
