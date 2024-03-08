<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'info' => new AddressResource($this->address),
            'image' => substr($this->getFirstMediaUrl('companies', 'main'),21),
            // 'image' => $this->getFirstMediaUrl('companies', 'main'),
        ];
    }
}
