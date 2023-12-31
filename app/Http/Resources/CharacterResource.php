<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "height" => $this->height,
            "mass" => $this->mass,
            "hair_color" => $this->hair_color,
            "skin_color" => $this->skin_color,
            "eye_color" => $this->eye_color,
            "birth_year" => $this->birth_year,
            "gender" => $this->gender,
            "homeworld" => $this->homeworld,
            "films" => $this->films,
            "species" => $this->species,
            "vehicles" => $this->vehicles,
            "starships" => $this->starships,
            "created" => $this->created,
            "edited" => $this->edited,
            "url" => $this->url
        ];
    }
}
