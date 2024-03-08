<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpiredDosesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dose' => $this->dose,
            'type' => $this->type,
            'quantity' => $this->quantity->available,
            'expected_loss' => $this->quantity->available * $this->price,
            'expired_date' => $this->expiry_date,
        ];
    }
}
