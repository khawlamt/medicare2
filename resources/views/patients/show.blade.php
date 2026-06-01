@extends('layouts.app')
@section('title', 'Fiche médecin')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                 style="width:80px;height:80px">
                <i class="bi bi-person-badge fs-1 text-success"></i>
            </div>
            <h5 class="fw-bold">{{ $medecin->nom_complet }}</h5>
            <p class="text-muted">{{ $medecin->specialite }}</p>
            <hr>
            <div class="text-start small">
                <p class="mb-1"><i class="bi bi-telephone me-2 text-muted"></i>{{ $medecin->telephone ?? '—' }}</p>
                <p class="mb-0"><i class="bi bi-envelope me-2 text-muted"></i>{{ $medecin->email ?? '—' }}</p>
            </div>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('medecins.edit', $medecin) }}" class="btn btn-warning btn-sm flex-fill text-white">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form method="POST" action="{{ route('medecins.destroy', $medecin) }}"
                      onsubmit="return confirm('Supprimer ce médecin ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-calendar-check me-2"></i>Rendez-vous de ce médecin
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Date</th><th>Patient</th><th>Motif</th><th>Statut</th></tr>
                    </thead>
                    <tbody>
                        @forelse($medecin->rendezVous as $rdv)
                            <tr>
                                <td>{{ $rdv->date_heure->format('d/m/Y H:i') }}</td>
                                <td>{{ $rdv->patient->nom_complet }}</td>
                                <td>{{ $rdv->motif ?? '—' }}</td>
                                <td><span class="badge badge-{{ $rdv->statut }}">{{ ucfirst($rdv->statut) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Aucun rendez-vous.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
