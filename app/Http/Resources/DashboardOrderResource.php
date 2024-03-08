<?php

namespace App\Http\Resources;

use App\Models\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DashboardOrderResource extends JsonResource
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
            'delivered_at' => $this->delivered_at,
            'status' => $this->status,
            'payment_status' => (bool)$this->payment_status,
            'bill' => $this->bill,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
