<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaccinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'schedule_at'   => $this->schedule_at?->format('Y-m-d'),
            'vaccinated_at' => $this->vaccinated_at?->format('Y-m-d'),
            'dose'          => DoseResource::make($this->whenLoaded('dose')),
        ];
    }
}
