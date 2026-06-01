<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;
use App\Http\Requests\StoreRendezVousRequest;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $query = RendezVous::with(['patient', 'medecin'])->latest('date_heure');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('date')) {
            $query->whereDate('date_heure', $request->date);
        }

        $rendezVous = $query->paginate(10)->withQueryString();
        $statuts    = RendezVous::STATUTS;

        return view('rendezvous.index', compact('rendezVous', 'statuts'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nom')->get();
        $medecins = Medecin::orderBy('nom')->get();
        $statuts  = RendezVous::STATUTS;

        return view('rendezvous.create', compact('patients', 'medecins', 'statuts'));
    }

    public function store(StoreRendezVousRequest $request)
    {
        RendezVous::create($request->validated());

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous créé avec succès.');
    }

    public function show(RendezVous $rendezVous)
    {
        $rendezVous->load(['patient', 'medecin']);
        return view('rendezvous.show', compact('rendezVous'));
    }

    public function edit(RendezVous $rendezVous)
    {
        $patients = Patient::orderBy('nom')->get();
        $medecins = Medecin::orderBy('nom')->get();
        $statuts  = RendezVous::STATUTS;

        return view('rendezvous.edit', compact('rendezVous', 'patients', 'medecins', 'statuts'));
    }

    public function update(StoreRendezVousRequest $request, RendezVous $rendezVous)
    {
        $rendezVous->update($request->validated());

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy(RendezVous $rendezVous)
    {
        $rendezVous->delete();

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
