<?php

namespace App\Http\Resources;

use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardOrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pharmacist = Pharmacist::find($this->pharmacist_id);
        return [
            'id' => $this->id,
            'pharmacy_name' => $pharmacist->address->name,
            'delivered_at' => $this->whenNotNull($this->delivered_at),
            'is_accepted' => $this->is_accepted,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'medicines_ordered' => OrderDetailsResource::collection($this->medicines),
            'bill' => $this->bill,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
