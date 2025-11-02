<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SucursalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'nombre'   => $this->nombre,
            'direccion'=> $this->direccion,
            'ciudad'   => $this->ciudad,
            'pais'     => $this->pais,
        ];
    }
}
