<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'reserva_id' => 'required|exists:reservas,id',
            'monto'      => 'required|numeric|min:0',
            'metodo'     => 'required|string|max:50',
            'fecha_pago' => 'nullable|date',
            'referencia' => 'nullable|string|max:100',
            'estado'     => 'sometimes|string|in:pagado,pendiente,fallido',
        ];
    }
}
