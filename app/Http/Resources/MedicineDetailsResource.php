<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $doses = $this->details->where('is_expired', false);
        if($request->type) {
            $doses = $this->details()->where('type', $request->type)->get();
        }
        return [
            'id' => $this->id,
            'commercial_name' => $this->getTranslation('commercial_name', 'ar'),
            'scientific_name' => $this->getTranslation('scientific_name', 'ar'),
            'description' => $this->getTranslation('description', 'ar'),
            // 'category' => $this->category->name,
            'company' => [
                'name' => $this->company->address->name,
                // 'image' => $this->company->getFirstMediaUrl('companies', 'thumb'),
                'image' => substr($this->company->getFirstMediaUrl('companies', 'thumb'),21),
            ],
            // 'medicine_image' => $this->getFirstMediaUrl('medicine', 'thumb'),
            'medicine_image' => substr($this->getFirstMediaUrl('medicine', 'main'),21),
            'doses' => DoseResource::collection($doses),
            'favorite' => $this->when(auth()->guard('sanctum')->user(), auth()->guard('sanctum')->user()?->favorites->contains($this->id))
        ];
    }
}
