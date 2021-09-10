<?php

namespace App\Http\Resources;

use App\Http\Resources\Extras\Category;
use App\Http\Resources\Extras\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class Scholarship extends JsonResource
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
            "title" => $this->title,
            "description" =>$this->description,
            "thumbnail" => $this->thumbnail,
            "deadline" => $this->deadline->toDayDateTimeString(),
            "createdAt" => $this->created_at->diffForHumans(),
            "country" => new Country($this->country),
            "category" => new Category($this->category),
            "createdBy" => new User($this->user)
        ];
    }
}
