<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePagoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'monto'      => 'sometimes|numeric|min:0',
            'metodo'     => 'sometimes|string|max:50',
            'fecha_pago' => 'nullable|date',
            'referencia' => 'nullable|string|max:100',
            'estado'     => 'sometimes|string|in:pagado,pendiente,fallido',
        ];
    }
}
