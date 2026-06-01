@extends('layouts.app')
@section('title', 'Médicaments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-capsule text-danger me-2"></i>Médicaments</h4>
    <a href="{{ route('medicaments.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg me-1"></i> Nouveau médicament
    </a>
</div>

{{-- Barre de recherche --}}
<form method="GET" class="mb-4">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Rechercher par nom, description...">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i>
        </button>
        @if(request('search'))
            <a href="{{ route('medicaments.index') }}" class="btn btn-outline-danger">
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
                    <th>Nom</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicaments as $medicament)
                    <tr>
                        <td class="text-muted">{{ $medicament->id }}</td>
                        <td class="fw-semibold">{{ $medicament->nom }}</td>
                        <td>
                            <span class="badge bg-{{ $medicament->stock == 0 ? 'danger' : ($medicament->stock <= $medicament->seuil_alerte ? 'warning' : 'success') }}">
                                {{ $medicament->stock }} unités
                            </span>
                        </td>
                        <td>
                            @if($medicament->stock_status === 'Rupture de stock')
                                <span class="badge bg-danger">{{ $medicament->stock_status }}</span>
                            @elseif($medicament->stock_status === 'Stock faible')
                                <span class="badge bg-warning text-dark">{{ $medicament->stock_status }}</span>
                            @else
                                <span class="badge bg-success">{{ $medicament->stock_status }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($medicament->prix, 2) }} €</td>
                        <td>
                            <a href="{{ route('medicaments.show', $medicament) }}"
                               class="btn btn-sm btn-outline-info me-1" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('medicaments.edit', $medicament) }}"
                               class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('medicaments.destroy', $medicament) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer ce médicament ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucun médicament trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $medicaments->links() }}</div>
@endsection
