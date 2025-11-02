<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarroFotoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'url'       => $this->url,
            'principal' => (bool)$this->principal,
            'orden'     => (int)$this->orden,
        ];
    }
}
