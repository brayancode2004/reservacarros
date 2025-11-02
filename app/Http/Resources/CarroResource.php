<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarroResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'placa'         => $this->placa,
            'marca'         => $this->marca,
            'modelo'        => $this->modelo,
            'anio'          => $this->anio,
            'tarifa_diaria' => (float)$this->tarifa_diaria,
            'estado'        => $this->estado,
            'sucursal'      => [
                'id'     => $this->sucursal->id,
                'nombre' => $this->sucursal->nombre,
            ],
            'fotos'         => CarroFotoResource::collection($this->whenLoaded('fotos')),
        ];
    }
}
