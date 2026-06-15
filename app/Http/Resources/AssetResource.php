<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'tag' => $this->tag,
            'name' => $this->name,
            'description' => $this->description,
            'brand' => $this->brand,
            'model' => $this->model,
            'series' => $this->series,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'decommission_reason' => $this->when($this->decommission_reason, $this->decommission_reason),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->when($this->deleted_at, $this->deleted_at),
        ];
    }
}
