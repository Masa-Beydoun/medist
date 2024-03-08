<?php

namespace App\Http\Resources;

use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'pharmacist_id' => $this->pharmacist_id,
            'delivered_at' => $this->whenNotNull($this->delivered_at),
            'is_accepted' => $this->is_accepted,
            'status' => $this->status,
            'bill' => $this->bill
        ];
    }
}
