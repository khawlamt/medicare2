<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $patientId = $this->route('patient')?->id;

        return [
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'date_naissance' => 'required|date|before:today',
            'groupe_sanguin' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'telephone'      => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:patients,email,' . $patientId,
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'            => 'Le nom est obligatoire.',
            'prenom.required'         => 'Le prénom est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.before'   => 'La date de naissance doit être dans le passé.',
            'email.unique'            => 'Cet email est déjà utilisé.',
        ];
    }
}
