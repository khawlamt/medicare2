@extends('layouts.app')
@section('title', 'Modifier patient')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-pencil text-warning me-2"></i>Modifier — {{ $patient->nom_complet }}
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.update', $patient) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom', $patient->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom', $patient->prenom) }}"
                           class="form-control @error('prenom') is-invalid @enderror">
                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance"
                           value="{{ old('date_naissance', $patient->date_naissance->format('Y-m-d')) }}"
                           class="form-control @error('date_naissance') is-invalid @enderror">
                    @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Groupe sanguin</label>
                    <select name="groupe_sanguin" class="form-select">
                        <option value="">— Sélectionner —</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $g)
                            <option value="{{ $g }}"
                                {{ old('groupe_sanguin', $patient->groupe_sanguin) == $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone"
                           value="{{ old('telephone', $patient->telephone) }}"
                           class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $patient->email) }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-check-lg me-1"></i> Mettre à jour
                </button>
                <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
