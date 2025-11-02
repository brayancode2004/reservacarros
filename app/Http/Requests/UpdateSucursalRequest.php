<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSucursalRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'nombre'    => 'sometimes|string|max:100',
            'direccion' => 'nullable|string|max:200',
            'ciudad'    => 'nullable|string|max:100',
            'pais'      => 'nullable|string|max:100',
        ];
    }
}
