@extends('layouts.app')
@section('title', 'Fiche médicament')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="bg-danger bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                 style="width:80px;height:80px">
                <i class="bi bi-capsule fs-1 text-danger"></i>
            </div>
            <h5 class="fw-bold">{{ $medicament->nom }}</h5>
            <hr>
            <div class="text-start small mb-3">
                <p class="mb-2">
                    <span class="text-muted">Stock :</span>
                    <span class="fw-semibold">{{ $medicament->stock }} unités</span>
                </p>
                <p class="mb-2">
                    <span class="text-muted">Seuil d'alerte :</span>
                    <span class="fw-semibold">{{ $medicament->seuil_alerte }} unités</span>
                </p>
                <p class="mb-0">
                    <span class="text-muted">Prix :</span>
                    <span class="fw-semibold">{{ number_format($medicament->prix, 2) }} €</span>
                </p>
            </div>
            <div class="mb-3">
                @if($medicament->stock_status === 'Rupture de stock')
                    <span class="badge bg-danger">{{ $medicament->stock_status }}</span>
                @elseif($medicament->stock_status === 'Stock faible')
                    <span class="badge bg-warning text-dark">{{ $medicament->stock_status }}</span>
                @else
                    <span class="badge bg-success">{{ $medicament->stock_status }}</span>
                @endif
            </div>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('medicaments.edit', $medicament) }}" class="btn btn-warning btn-sm flex-fill text-white">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form method="POST" action="{{ route('medicaments.destroy', $medicament) }}"
                      onsubmit="return confirm('Supprimer ce médicament ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-info-circle me-2"></i>Informations détaillées
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-semibold">ID</label>
                        <p class="mb-0">{{ $medicament->id }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-semibold">Créé le</label>
                        <p class="mb-0">{{ $medicament->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-semibold">Dernière modification</label>
                        <p class="mb-0">{{ $medicament->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-semibold">Status du stock</label>
                        <p class="mb-0">
                            @if($medicament->stock_status === 'Rupture de stock')
                                <span class="badge bg-danger">{{ $medicament->stock_status }}</span>
                            @elseif($medicament->stock_status === 'Stock faible')
                                <span class="badge bg-warning text-dark">{{ $medicament->stock_status }}</span>
                            @else
                                <span class="badge bg-success">{{ $medicament->stock_status }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
