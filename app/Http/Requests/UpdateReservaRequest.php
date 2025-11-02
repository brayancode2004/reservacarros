<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'sucursal_retiro_id'    => 'sometimes|exists:sucursales,id',
            'sucursal_devolucion_id'=> 'sometimes|exists:sucursales,id',
            'fecha_inicio'          => 'sometimes|date',
            'fecha_fin'             => 'sometimes|date|after:fecha_inicio',
            'estado'                => 'sometimes|string|in:pendiente,confirmada,cancelada,completada',
            // si envían carros en update, se re-sincroniza
            'carros'                => 'sometimes|array|min:1',
            'carros.*.carro_id'     => 'required_with:carros|exists:carros,id',
            'carros.*.dias'         => 'nullable|integer|min:1',
            'carros.*.tarifa_diaria'=> 'nullable|numeric|min:0',
        ];
    }
}
