<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'space_sqm' => $this->space_sqm,
            'max_guests' => $this->max_guests,
            'number_of_rooms' => $this->number_of_rooms,
            'price_per_night' => $this->price_per_night,
            'is_listed' => $this->is_listed,
            'created_at' => $this->created_at,
            'property_type' => $this->propertyType->name,
            'image_url' => $this->image_url
        ];
    }
}
