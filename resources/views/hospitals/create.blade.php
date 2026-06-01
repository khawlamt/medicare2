@extends('layouts.app')
@section('title', 'Nouvel hôpital')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-hospital text-danger me-2"></i>Nouvel hôpital
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('hospitals.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           placeholder="Ex: Hôpital la Rabta">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="prive" {{ old('type') == 'prive' ? 'selected' : '' }}>Privé</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ville <span class="text-danger">*</span></label>
                    <input type="text" name="ville" value="{{ old('ville') }}"
                           class="form-control @error('ville') is-invalid @enderror"
                           placeholder="Ex: Tunis">
                    @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gouvernorat <span class="text-danger">*</span></label>
                    <select name="gouvernorat" class="form-select @error('gouvernorat') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach($gouvernorats as $gov)
                            <option value="{{ $gov }}" {{ old('gouvernorat') == $gov ? 'selected' : '' }}>
                                {{ $gov }}
                            </option>
                        @endforeach
                    </select>
                    @error('gouvernorat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" value="{{ old('adresse') }}"
                           class="form-control" placeholder="Adresse complète">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}"
                           class="form-control" placeholder="Ex: +216 71 123 456">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="number" name="latitude" value="{{ old('latitude') }}" step="0.00000001"
                           class="form-control" placeholder="Ex: 36.8065">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="number" name="longitude" value="{{ old('longitude') }}" step="0.00000001"
                           class="form-control" placeholder="Ex: 10.1719">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                              class="form-control"
                              placeholder="Informations supplémentaires...">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check">
                                <input type="hidden" name="urgence" value="0">
                                <input class="form-check-input" type="checkbox" name="urgence" id="urgence"
                                       value="1" {{ old('urgence') ? 'checked' : '' }}>
                                <label class="form-check-label" for="urgence">
                                    Urgence
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check">
                                <input type="hidden" name="maternite" value="0">
                                <input class="form-check-input" type="checkbox" name="maternite" id="maternite"
                                       value="1" {{ old('maternite') ? 'checked' : '' }}>
                                <label class="form-check-label" for="maternite">
                                    Maternité
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check">
                                <input type="hidden" name="chirurgie" value="0">
                                <input class="form-check-input" type="checkbox" name="chirurgie" id="chirurgie"
                                       value="1" {{ old('chirurgie') ? 'checked' : '' }}>
                                <label class="form-check-label" for="chirurgie">
                                    Chirurgie
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer
                </button>
                <a href="{{ route('hospitals.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
