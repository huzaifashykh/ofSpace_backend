<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Favourite extends JsonResource
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
            "id" => $this->id,
            "user" => new User($this->user),
            "scholarship" => new Scholarship($this->scholarship)
        ];
    }
}