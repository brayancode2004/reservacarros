<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarroFotoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'url'       => 'required|url|max:2048',
            'principal' => 'sometimes|boolean',
            'orden'     => 'sometimes|integer|min:1',
        ];
    }
}
