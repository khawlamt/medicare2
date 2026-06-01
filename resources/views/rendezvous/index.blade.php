@extends('layouts.app')
@section('title', 'Rendez-vous')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-calendar-check text-info me-2"></i>Rendez-vous</h4>
    <a href="{{ route('rendezvous.create') }}" class="btn btn-info text-white">
        <i class="bi bi-plus-lg me-1"></i> Nouveau rendez-vous
    </a>
</div>

{{-- Filtres --}}
<form method="GET" class="mb-4 d-flex gap-2 flex-wrap">
    <input type="date" name="date" value="{{ request('date') }}" class="form-control" style="width:180px">
    <select name="statut" class="form-select" style="width:180px">
        <option value="">— Tous les statuts —</option>
        @foreach($statuts as $s)
            <option value="{{ $s }}" {{ request('statut') == $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-outline-secondary">
        <i class="bi bi-funnel"></i> Filtrer
    </button>
    @if(request('statut') || request('date'))
        <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-danger">
            <i class="bi bi-x"></i> Réinitialiser
        </a>
    @endif
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Médecin</th>
                    <th>Date & Heure</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rendezVous as $rdv)
                    <tr>
                        <td class="text-muted">{{ $rdv->id }}</td>
                        <td class="fw-semibold">{{ $rdv->patient->nom_complet }}</td>
                        <td>{{ $rdv->medecin->nom_complet }}<br>
                            <small class="text-muted">{{ $rdv->medecin->specialite }}</small>
                        </td>
                        <td>{{ $rdv->date_heure->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $rdv->date_heure->format('H:i') }}</small>
                        </td>
                        <td>{{ Str::limit($rdv->motif, 40) ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $rdv->statut }}">
                                {{ ucfirst($rdv->statut) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('rendezvous.show', $rdv) }}"
                               class="btn btn-sm btn-outline-info me-1" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('rendezvous.edit', $rdv) }}"
                               class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('rendezvous.destroy', $rdv) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                            Aucun rendez-vous trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $rendezVous->links() }}</div>
@endsection
