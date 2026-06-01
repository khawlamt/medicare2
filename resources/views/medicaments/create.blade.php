@extends('layouts.app')
@section('title', 'Nouveau médicament')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-capsule-pill text-danger me-2"></i>Nouveau médicament
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('medicaments.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           placeholder="Ex: Paracétamol 500mg">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                           class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Seuil d'alerte <span class="text-danger">*</span></label>
                    <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', 10) }}" min="0"
                           class="form-control @error('seuil_alerte') is-invalid @enderror"
                           placeholder="Stock minimum d'alerte">
                    @error('seuil_alerte')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prix (€) <span class="text-danger">*</span></label>
                    <input type="number" name="prix" value="{{ old('prix') }}" step="0.01" min="0"
                           class="form-control @error('prix') is-invalid @enderror">
                    @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer
                </button>
                <a href="{{ route('medicaments.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
