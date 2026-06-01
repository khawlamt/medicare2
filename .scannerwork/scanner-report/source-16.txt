<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicaments = Medicament::when(request('search'), function($query) {
            return $query->search(request('search'));
        })->paginate(10);

        return view('medicaments.index', compact('medicaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
            'prix' => 'required|numeric|min:0',
        ]);

        Medicament::create($validated);

        return redirect()->route('medicaments.index')
                        ->with('success', 'Médicament créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicament $medicament)
    {
        return view('medicaments.show', compact('medicament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicament $medicament)
    {
        return view('medicaments.edit', compact('medicament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicament $medicament)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
            'prix' => 'required|numeric|min:0',
        ]);

        $medicament->update($validated);

        return redirect()->route('medicaments.index')
                        ->with('success', 'Médicament modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicament $medicament)
    {
        $medicament->delete();

        return redirect()->route('medicaments.index')
                        ->with('success', 'Médicament supprimé avec succès.');
    }
}
