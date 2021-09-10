<?php

namespace App\Http\Resources;

use App\Http\Resources\Extras\Country;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class User extends JsonResource
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
            "fullName" => $this->full_name,
            "profilePicture" => $this->profile_picture,
            "bio" => $this->bio,
            "country" => new Country($this->country)
        ];
    }
}
