@extends('layouts.app')
@section('title', 'Hôpitaux en Tunisie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-hospital text-danger me-2"></i>Hôpitaux en Tunisie</h4>
    <a href="{{ route('hospitals.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg me-1"></i> Nouvel hôpital
    </a>
</div>

{{-- Barre de recherche et filtres --}}
<form method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Rechercher par nom, ville, gouvernorat...">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('hospitals.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <select name="gouvernorat" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tous les gouvernorats --</option>
                @foreach($gouvernorats as $gov)
                    <option value="{{ $gov }}" {{ request('gouvernorat') == $gov ? 'selected' : '' }}>
                        {{ $gov }}
                    </option>
                @endforeach
            </select>
        </div>
        @if(request('gouvernorat'))
            <div class="col-md-2">
                <a href="{{ route('hospitals.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i>Réinitialiser
                </a>
            </div>
        @endif
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Gouvernorat</th>
                    <th>Type</th>
                    <th>Services</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hospitals as $hospital)
                    <tr>
                        <td class="text-muted">{{ $hospital->id }}</td>
                        <td class="fw-semibold">{{ $hospital->nom }}</td>
                        <td>{{ $hospital->ville }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $hospital->gouvernorat }}</span>
                        </td>
                        <td>
                            @if($hospital->type === 'public')
                                <span class="badge bg-success">Public</span>
                            @else
                                <span class="badge bg-warning text-dark">Privé</span>
                            @endif
                        </td>
                        <td>
                            <small>
                                @if($hospital->urgence)
                                    <span class="badge bg-danger">Urgence</span>
                                @endif
                                @if($hospital->maternite)
                                    <span class="badge bg-info">Maternité</span>
                                @endif
                                @if($hospital->chirurgie)
                                    <span class="badge bg-secondary">Chirurgie</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('hospitals.show', $hospital) }}"
                               class="btn btn-sm btn-outline-info me-1" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('hospitals.edit', $hospital) }}"
                               class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('hospitals.destroy', $hospital) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer cet hôpital ?')">
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
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun hôpital trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $hospitals->links() }}</div>
@endsection
