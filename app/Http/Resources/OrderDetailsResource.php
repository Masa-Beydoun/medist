<?php

namespace App\Http\Resources;

use App\Models\Medicine;
use App\Models\MedicineDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dose = MedicineDetails::where('id', $this->dose_id)->first();
        $medicine = Medicine::find($this->medicine_id);
        return [
            'medicine' => $medicine->commercial_name,
            'dose' => $dose->dose,
            'quantity' =>  $this->quantity,
            'priceEach' =>  $this->price,
            'overAllPrice' =>  $this->price * $this->quantity,
        ];
    }
}
