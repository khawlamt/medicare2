<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nom'          => 'required|string|max:150',
            'description'  => 'nullable|string|max:500',
            'stock'        => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:1',
            'prix'         => 'nullable|numeric|min:0',
        ];
    }
}
