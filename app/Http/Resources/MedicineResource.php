<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
            'commercial_name' => $this->getTranslation('commercial_name', $request->header('locale')),
            'scientific_name' => $this->getTranslation('scientific_name', $request->header('locale')),
            'company' => [
                'name' => $this->company->address->name,
                // 'image' => $this->company->getFirstMediaUrl('companies', 'thumb'),
                'image' => substr($this->company->getFirstMediaUrl('companies', 'thumb'),21),
            ],
            'image' => substr($this->getFirstMediaUrl('medicine', 'main'),21),
            'favorite' => auth()->guard('sanctum')->user()?->favorites->contains($this->id)
        ];
    }
}
