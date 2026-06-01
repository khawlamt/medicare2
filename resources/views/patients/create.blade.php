@extends('layouts.app')
@section('title', 'Nouveau patient')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-person-plus text-primary me-2"></i>Nouveau patient
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}"
                           class="form-control @error('prenom') is-invalid @enderror">
                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                           class="form-control @error('date_naissance') is-invalid @enderror">
                    @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Groupe sanguin</label>
                    <select name="groupe_sanguin" class="form-select">
                        <option value="">— Sélectionner —</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $g)
                            <option value="{{ $g }}" {{ old('groupe_sanguin') == $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}"
                           class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer
                </button>
                <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
