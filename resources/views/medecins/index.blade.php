@extends('layouts.app')
@section('title', 'Médecins')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-badge text-success me-2"></i>Médecins</h4>
    <a href="{{ route('medecins.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nouveau médecin
    </a>
</div>

<form method="GET" class="mb-4">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Rechercher par nom, spécialité...">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
        @if(request('search'))
            <a href="{{ route('medecins.index') }}" class="btn btn-outline-danger"><i class="bi bi-x"></i></a>
        @endif
    </div>
</form>

<div class="row g-3">
    @forelse($medecins as $medecin)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;flex-shrink:0">
                            <i class="bi bi-person-badge text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ $medecin->nom_complet }}</h6>
                            <small class="text-muted">{{ $medecin->specialite }}</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-1">
                        <i class="bi bi-envelope me-1"></i>{{ $medecin->email ?? '—' }}
                    </p>
                    <p class="small text-muted mb-2">
                        <i class="bi bi-telephone me-1"></i>{{ $medecin->telephone ?? '—' }}
                    </p>
                    <span class="badge bg-secondary">{{ $medecin->rendez_vous_count }} RDV</span>
                </div>
                <div class="card-footer bg-white d-flex gap-2">
                    <a href="{{ route('medecins.show', $medecin) }}" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('medecins.edit', $medecin) }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('medecins.destroy', $medecin) }}"
                          class="ms-auto" onsubmit="return confirm('Supprimer ce médecin ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-inbox fs-3 d-block mb-2"></i>Aucun médecin trouvé.
        </div>
    @endforelse
</div>

<div class="mt-3">{{ $medecins->links() }}</div>
@endsection
