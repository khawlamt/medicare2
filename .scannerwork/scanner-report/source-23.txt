<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedecinRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $medecinId = $this->route('medecin')?->id;

        return [
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'specialite'=> 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'email'     => 'nullable|email|unique:medecins,email,' . $medecinId,
        ];
    }
}
