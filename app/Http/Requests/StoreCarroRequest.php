<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarroRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'placa'         => 'required|string|max:50|unique:carros,placa',
            'marca'         => 'required|string|max:100',
            'modelo'        => 'required|string|max:100',
            'anio'          => 'required|integer|min:1900|max:2100',
            'tarifa_diaria' => 'required|numeric|min:0',
            'estado'        => 'sometimes|string|in:disponible,mantenimiento,ocupado',
            'sucursal_id'   => 'required|exists:sucursales,id',
        ];
    }
}

