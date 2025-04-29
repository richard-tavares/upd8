<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepresentativeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'city_id' => $this->city->id ?? null,
            'city' => $this->city->name ?? null,
            'state' => $this->city->state ?? null,
        ];
    }
}
