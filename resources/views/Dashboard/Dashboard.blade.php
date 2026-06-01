@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')

{{-- Cartes statistiques --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-people fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['patients'] }}</div>
                    <div class="text-muted small">Patients</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-person-badge fs-3 text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['medecins'] }}</div>
                    <div class="text-muted small">Médecins</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-calendar-check fs-3 text-info"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['rdv_aujourd_hui'] }}</div>
                    <div class="text-muted small">RDV aujourd'hui</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['alertes_stock'] }}</div>
                    <div class="text-muted small">Alertes stock</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- RDV du jour --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-calendar-day me-2 text-info"></i>Rendez-vous aujourd'hui</span>
                <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-outline-info">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @forelse($rdv_aujourd_hui as $rdv)
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="text-center" style="min-width:50px">
                            <div class="fw-bold text-info">{{ $rdv->date_heure->format('H:i') }}</div>
                        </div>
                        <div class="flex-fill">
                            <div class="fw-semibold">{{ $rdv->patient->nom_complet }}</div>
                            <small class="text-muted">{{ $rdv->medecin->nom_complet }} — {{ $rdv->medecin->specialite }}</small>
                        </div>
                        <span class="badge badge-{{ $rdv->statut }}">{{ ucfirst($rdv->statut) }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                        Aucun rendez-vous aujourd'hui.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Alertes stock --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Alertes médicaments</span>
                <a href="{{ route('medicaments.index', ['faible_stock' => 1]) }}"
                   class="btn btn-sm btn-outline-danger">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @forelse($alertes_medicaments as $med)
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="bg-danger bg-opacity-10 rounded p-2">
                            <i class="bi bi-capsule text-danger"></i>
                        </div>
                        <div class="flex-fill">
                            <div class="fw-semibold">{{ $med->nom }}</div>
                            <small class="text-muted">Seuil : {{ $med->seuil_alerte }}</small>
                        </div>
                        <span class="badge bg-{{ $med->stock_badge }}">{{ $med->stock }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-check-circle fs-3 d-block mb-2 text-success"></i>
                        Tous les stocks sont OK.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Raccourci Chatbot --}}
    <div class="col-12">
        <div class="card border-0" style="background: linear-gradient(135deg, #1a2340, #2d3a5e);">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div class="text-white">
                    <h5 class="fw-bold mb-1"><i class="bi bi-robot me-2"></i>Assistant IA MediCare</h5>
                    <p class="mb-0 text-white-50">
                        Posez vos questions en langage naturel sur vos données médicales.
                    </p>
                </div>
                <a href="{{ route('chatbot.index') }}" class="btn btn-light fw-semibold px-4">
                    Ouvrir le chatbot <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
