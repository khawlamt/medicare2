@extends('layouts.app')
@section('title', 'Détail rendez-vous')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-calendar-event text-info me-2"></i>Rendez-vous #{{ $rendezVous->id }}
        </h5>
        <span class="badge badge-{{ $rendezVous->statut }} fs-6">
            {{ ucfirst($rendezVous->statut) }}
        </span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="text-muted small">Patient</label>
                <p class="fw-semibold mb-0">
                    <a href="{{ route('patients.show', $rendezVous->patient) }}">
                        {{ $rendezVous->patient->nom_complet }}
                    </a>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Médecin</label>
                <p class="fw-semibold mb-0">
                    <a href="{{ route('medecins.show', $rendezVous->medecin) }}">
                        {{ $rendezVous->medecin->nom_complet }}
                    </a>
                    <br><small class="text-muted">{{ $rendezVous->medecin->specialite }}</small>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Date & Heure</label>
                <p class="fw-semibold mb-0">
                    <i class="bi bi-calendar me-1"></i>{{ $rendezVous->date->format('d/m/Y') }}
                    à {{ $rendezVous->date->format('H:i') }}
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Créé le</label>
                <p class="fw-semibold mb-0">{{ $rendezVous->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-12">
                <label class="text-muted small">Motif</label>
                <p class="mb-0">{{ $rendezVous->motif ?? 'Aucun motif renseigné.' }}</p>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('rendezvous.edit', $rendezVous) }}" class="btn btn-warning text-white">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
            <form method="POST" action="{{ route('rendezvous.destroy', $rendezVous) }}"
                  onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash me-1"></i> Supprimer</button>
            </form>
            <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-secondary ms-auto">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>
</div>
</div>
</div>
@endsection
