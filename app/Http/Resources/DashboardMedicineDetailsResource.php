<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardMedicineDetailsResource extends JsonResource
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
            'commercial_name' => $this->getTranslation('commercial_name', 'en'),
            'scientific_name' => $this->getTranslation('scientific_name', 'en'),
            'description' => $this->getTranslation('description', 'en'),
            // 'company' => $this->company->address->name,
            'company' => [
                'name' => $this->company->address->name,
                // 'image' => $this->company->getFirstMediaUrl('companies', 'thumb'),
                'image' => substr($this->company->getFirstMediaUrl('companies', 'thumb'),21),
            ],
            'image' => substr($this->getFirstMediaUrl('medicine', 'thumb'),21),
            'doses_count' => count($this->details),
            'doses' => DoseResource::collection($this->details->where('is_expired', false))
        ];
    }
}
