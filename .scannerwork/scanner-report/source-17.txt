<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::withCount('rendezVous')->latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $patients = $query->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated());

        return redirect()->route('patients.index')
            ->with('success', 'Patient ajouté avec succès.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['rendezVous.medecin' => fn($q) => $q->latest()]);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(StorePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.index')
            ->with('success', 'Patient mis à jour avec succès.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient supprimé avec succès.');
    }
}
