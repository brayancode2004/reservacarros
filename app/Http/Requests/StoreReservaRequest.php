<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'usuario_id'           => 'required|exists:users,id',
            'sucursal_retiro_id'   => 'required|exists:sucursales,id',
            'sucursal_devolucion_id'=> 'required|exists:sucursales,id',
            'fecha_inicio'         => 'required|date',
            'fecha_fin'            => 'required|date|after:fecha_inicio',
            'estado'               => 'sometimes|string|in:pendiente,confirmada,cancelada,completada',
            // carros es un array de items {carro_id, dias?, tarifa_diaria?}
            'carros'               => 'required|array|min:1',
            'carros.*.carro_id'    => 'required|exists:carros,id',
            'carros.*.dias'        => 'nullable|integer|min:1',
            'carros.*.tarifa_diaria'=> 'nullable|numeric|min:0',
        ];
    }
}
