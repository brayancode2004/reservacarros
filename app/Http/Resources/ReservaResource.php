<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'usuario_id'=> $this->usuario_id,
            'sucursal_retiro_id'    => $this->sucursal_retiro_id,
            'sucursal_devolucion_id'=> $this->sucursal_devolucion_id,
            'fecha_inicio'          => $this->fecha_inicio?->toIso8601String(),
            'fecha_fin'             => $this->fecha_fin?->toIso8601String(),
            'precio_total'          => (float)$this->precio_total,
            'estado'                => $this->estado,
            'carros' => $this->whenLoaded('carros', function () {
                return $this->carros->map(function ($c) {
                    return [
                        'id'            => $c->id,
                        'placa'         => $c->placa,
                        'marca'         => $c->marca,
                        'modelo'        => $c->modelo,
                        'anio'          => $c->anio,
                        'pivot'         => [
                            'tarifa_diaria' => (float)$c->pivot->tarifa_diaria,
                            'dias'          => (int)$c->pivot->dias,
                            'subtotal'      => (float)$c->pivot->subtotal,
                        ]
                    ];
                });
            }),
        ];
    }
}
