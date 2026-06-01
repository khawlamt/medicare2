<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRendezVousRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date|after:now',
            'statut'     => 'required|in:planifie,confirme,annule,effectue',
            'motif'      => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after' => 'La date du rendez-vous doit être dans le futur.',
        ];
    }
}
