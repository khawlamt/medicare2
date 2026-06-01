<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Medicament;
use App\Models\Hospital;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'patients'          => Patient::count(),
            'medecins'          => Medecin::count(),
            'rdv_aujourd_hui'   => RendezVous::today()->count(),
            'rdv_demain'        => RendezVous::tomorrow()->count(),
            'alertes_stock'     => Medicament::faibleStock()->count(),
            'rdv_total'         => RendezVous::count(),
        ];

        $rdv_aujourd_hui = RendezVous::with(['patient', 'medecin'])
            ->today()
            ->actifs()
            ->orderBy('date_heure')
            ->take(5)
            ->get();

        $alertes_medicaments = Medicament::faibleStock()
            ->orderBy('stock')
            ->take(5)
            ->get();

        $hospitals = Hospital::limit(10)->get();

        return view('dashboard', compact('stats', 'rdv_aujourd_hui', 'alertes_medicaments', 'hospitals'));
    }
}
