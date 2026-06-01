<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Http\Requests\StoreMedecinRequest;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index(Request $request)
    {
        $query = Medecin::withCount('rendezVous')->latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $medecins = $query->paginate(10)->withQueryString();

        return view('medecins.index', compact('medecins'));
    }

    public function create()
    {
        return view('medecins.create');
    }

    public function store(StoreMedecinRequest $request)
    {
        Medecin::create($request->validated());

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin ajouté avec succès.');
    }

    public function show(Medecin $medecin)
    {
        $medecin->load(['rendezVous.patient']);
        return view('medecins.show', compact('medecin'));
    }

    public function edit(Medecin $medecin)
    {
        return view('medecins.edit', compact('medecin'));
    }

    public function update(StoreMedecinRequest $request, Medecin $medecin)
    {
        $medecin->update($request->validated());

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin mis à jour avec succès.');
    }

    public function destroy(Medecin $medecin)
    {
        $medecin->delete();

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin supprimé avec succès.');
    }
}
