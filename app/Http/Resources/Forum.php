<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Forum extends JsonResource
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
            "createdAt" => $this->created_at->diffForHumans(),
            "title" => $this->title,
            "description" => $this->description,
            "createdBy" => new User($this->user)
        ];
    }
}
