<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'reserva_id' => $this->reserva_id,
            'monto'      => (float)$this->monto,
            'metodo'     => $this->metodo,
            'fecha_pago' => optional($this->fecha_pago)->toIso8601String(),
            'referencia' => $this->referencia,
            'estado'     => $this->estado,
        ];
    }
}
