@extends('layouts.app')
@section('title', 'Modifier médecin')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-pencil text-warning me-2"></i>Modifier — {{ $medecin->nom_complet }}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('medecins.update', $medecin) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom', $medecin->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom', $medecin->prenom) }}"
                           class="form-control @error('prenom') is-invalid @enderror">
                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Spécialité <span class="text-danger">*</span></label>
                    <input type="text" name="specialite" value="{{ old('specialite', $medecin->specialite) }}"
                           class="form-control @error('specialite') is-invalid @enderror">
                    @error('specialite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $medecin->telephone) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $medecin->email) }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-check-lg me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('medecins.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
