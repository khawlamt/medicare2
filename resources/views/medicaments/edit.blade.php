@extends('layouts.app')
@section('title', 'Modifier médicament')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-pencil text-warning me-2"></i>Modifier — {{ $medicament->nom }}
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('medicaments.update', $medicament) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom', $medicament->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           placeholder="Ex: Paracétamol 500mg">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $medicament->stock) }}" min="0"
                           class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Seuil d'alerte <span class="text-danger">*</span></label>
                    <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', $medicament->seuil_alerte) }}" min="0"
                           class="form-control @error('seuil_alerte') is-invalid @enderror"
                           placeholder="Stock minimum d'alerte">
                    @error('seuil_alerte')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prix (€) <span class="text-danger">*</span></label>
                    <input type="number" name="prix" value="{{ old('prix', $medicament->prix) }}" step="0.01" min="0"
                           class="form-control @error('prix') is-invalid @enderror">
                    @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-check-lg me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('medicaments.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
