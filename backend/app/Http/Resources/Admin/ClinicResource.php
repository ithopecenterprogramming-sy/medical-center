<?php
namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'room_number'    => $this->room_number,
            'description'    => $this->description,
            'is_active'      => $this->is_active,
            'department'     => new DepartmentResource($this->whenLoaded('department')),
            'doctors_count'  => $this->whenCounted('doctors'),
            'created_at'     => $this->created_at?->toDateTimeString(),
        ];
    }
}