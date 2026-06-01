<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::when(request('search'), function($query) {
            return $query->search(request('search'));
        })
        ->when(request('gouvernorat'), function($query) {
            return $query->byGovernorate(request('gouvernorat'));
        })
        ->paginate(10);

        $gouvernorats = Hospital::distinct('gouvernorat')->pluck('gouvernorat')->sort();

        return view('hospitals.index', compact('hospitals', 'gouvernorats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gouvernorats = [
            'Ariana', 'Béja', 'Ben Arous', 'Bizerte', 'Gabès', 'Gafsa',
            'Jendouba', 'Kairouan', 'Kasserine', 'Kebili', 'Kef', 'Mahdia',
            'Manouba', 'Médenine', 'Monastir', 'Nabeul', 'Sfax', 'Sidi Bouzid',
            'Siliana', 'Sousse', 'Tataouine', 'Tozeur', 'Tunis', 'Zaghouan'
        ];

        return view('hospitals.create', compact('gouvernorats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'gouvernorat' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
            'type' => 'required|in:public,prive',
            'urgence' => 'boolean',
            'maternite' => 'boolean',
            'chirurgie' => 'boolean',
        ]);

        $validated['urgence'] = $request->boolean('urgence');
        $validated['maternite'] = $request->boolean('maternite');
        $validated['chirurgie'] = $request->boolean('chirurgie');

        Hospital::create($validated);

        return redirect()->route('hospitals.index')
                        ->with('success', 'Hôpital créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        $gouvernorats = [
            'Ariana', 'Béja', 'Ben Arous', 'Bizerte', 'Gabès', 'Gafsa',
            'Jendouba', 'Kairouan', 'Kasserine', 'Kebili', 'Kef', 'Mahdia',
            'Manouba', 'Médenine', 'Monastir', 'Nabeul', 'Sfax', 'Sidi Bouzid',
            'Siliana', 'Sousse', 'Tataouine', 'Tozeur', 'Tunis', 'Zaghouan'
        ];

        return view('hospitals.edit', compact('hospital', 'gouvernorats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'gouvernorat' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
            'type' => 'required|in:public,prive',
            'urgence' => 'boolean',
            'maternite' => 'boolean',
            'chirurgie' => 'boolean',
        ]);

        $validated['urgence'] = $request->boolean('urgence');
        $validated['maternite'] = $request->boolean('maternite');
        $validated['chirurgie'] = $request->boolean('chirurgie');

        $hospital->update($validated);

        return redirect()->route('hospitals.index')
                        ->with('success', 'Hôpital modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()->route('hospitals.index')
                        ->with('success', 'Hôpital supprimé avec succès.');
    }
}
