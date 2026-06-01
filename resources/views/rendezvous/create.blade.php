@extends('layouts.app')
@section('title', 'Nouveau rendez-vous')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-calendar-plus text-info me-2"></i>Nouveau rendez-vous
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('rendezvous.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Patient <span class="text-danger">*</span></label>
                    <select name="patient_id"
                            class="form-select @error('patient_id') is-invalid @enderror">
                        <option value="">— Sélectionner un patient —</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}"
                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->nom_complet }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Médecin <span class="text-danger">*</span></label>
                    <select name="medecin_id"
                            class="form-select @error('medecin_id') is-invalid @enderror">
                        <option value="">— Sélectionner un médecin —</option>
                        @foreach($medecins as $medecin)
                            <option value="{{ $medecin->id }}"
                                {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                                {{ $medecin->nom_complet }} — {{ $medecin->specialite }}
                            </option>
                        @endforeach
                    </select>
                    @error('medecin_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date & Heure <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="date_heure" value="{{ old('date_heure') }}"
                           class="form-control @error('date_heure') is-invalid @enderror">
                    @error('date_heure')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Statut <span class="text-danger">*</span></label>
                    <select name="statut" class="form-select @error('statut') is-invalid @enderror">
                        @foreach($statuts as $s)
                            <option value="{{ $s }}" {{ old('statut', 'planifie') == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Motif</label>
                    <textarea name="motif" rows="3"
                              class="form-control @error('motif') is-invalid @enderror"
                              placeholder="Raison de la consultation...">{{ old('motif') }}</textarea>
                    @error('motif')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-info text-white">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer
                </button>
                <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
