<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSucursalRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'nombre'    => 'required|string|max:100',
            'direccion' => 'nullable|string|max:200',
            'ciudad'    => 'nullable|string|max:100',
            'pais'      => 'nullable|string|max:100',
        ];
    }
}
