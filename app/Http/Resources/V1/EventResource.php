<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'imageCover' => $this->image_cover,
            'imageBackground' => $this->image_background,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}