<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'service_type_id' => $this->service_type_id,
            'service_type'    => new ServiceTypeResource($this->whenLoaded('serviceType')),
            'name'            => $this->name,
            'description'     => $this->description,
            'cost'            => (float) $this->cost,
            'is_active'       => (bool) $this->is_active,
            'created_at'      => $this->created_at?->toIso8601String(),
            'updated_at'      => $this->updated_at?->toIso8601String(),
        ];
    }
}