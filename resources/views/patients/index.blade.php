@extends('layouts.app')
@section('title', 'Patients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Patients</h4>
    <a href="{{ route('patients.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouveau patient
    </a>
</div>

{{-- Barre de recherche --}}
<form method="GET" class="mb-4">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Rechercher par nom, prénom, email...">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i>
        </button>
        @if(request('search'))
            <a href="{{ route('patients.index') }}" class="btn btn-outline-danger">
                <i class="bi bi-x"></i>
            </a>
        @endif
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom complet</th>
                    <th>Date de naissance</th>
                    <th>Groupe sanguin</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>RDV</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td class="text-muted">{{ $patient->id }}</td>
                        <td class="fw-semibold">{{ $patient->nom_complet }}</td>
                        <td>{{ $patient->date_naissance->format('d/m/Y') }}
                            <span class="text-muted small">({{ $patient->age }} ans)</span>
                        </td>
                        <td>
                            @if($patient->groupe_sanguin)
                                <span class="badge bg-danger">{{ $patient->groupe_sanguin }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $patient->telephone ?? '—' }}</td>
                        <td>{{ $patient->email ?? '—' }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $patient->rendez_vous_count }}</span>
                        </td>
                        <td>
                            <a href="{{ route('patients.show', $patient) }}"
                               class="btn btn-sm btn-outline-info me-1" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('patients.edit', $patient) }}"
                               class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('patients.destroy', $patient) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ce patient ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun patient trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $patients->links() }}</div>
@endsection
