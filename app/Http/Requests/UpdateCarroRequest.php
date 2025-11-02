<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarroRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('carro')->id ?? null;
        return [
            'placa'         => "sometimes|string|max:50|unique:carros,placa,{$id}",
            'marca'         => 'sometimes|string|max:100',
            'modelo'        => 'sometimes|string|max:100',
            'anio'          => 'sometimes|integer|min:1900|max:2100',
            'tarifa_diaria' => 'sometimes|numeric|min:0',
            'estado'        => 'sometimes|string|in:disponible,mantenimiento,ocupado',
            'sucursal_id'   => 'sometimes|exists:sucursales,id',
        ];
    }
}
