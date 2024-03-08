<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dose_id' => $this->id,
            'dose' => $this->dose,
            'price' => (int)$this->price,
            'type' => $this->type,
            'quantity_available' => $this->quantity->available,
            // 'expiry_date' => $this->expiry_date,
        ];
    }
}
