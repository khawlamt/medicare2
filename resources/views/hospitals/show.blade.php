@extends('layouts.app')
@section('title', 'Fiche hôpital')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="bg-danger bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                 style="width:80px;height:80px">
                <i class="bi bi-hospital fs-1 text-danger"></i>
            </div>
            <h5 class="fw-bold">{{ $hospital->nom }}</h5>
            <p class="text-muted small">{{ $hospital->ville }} - {{ $hospital->gouvernorat }}</p>
            <hr>
            <div class="text-start small mb-3">
                @if($hospital->adresse)
                    <p class="mb-2">
                        <i class="bi bi-geo-alt text-muted me-2"></i>{{ $hospital->adresse }}
                    </p>
                @endif
                @if($hospital->telephone)
                    <p class="mb-2">
                        <i class="bi bi-telephone text-muted me-2"></i>{{ $hospital->telephone }}
                    </p>
                @endif
                @if($hospital->email)
                    <p class="mb-2">
                        <i class="bi bi-envelope text-muted me-2"></i>{{ $hospital->email }}
                    </p>
                @endif
            </div>
            <div class="mb-3">
                @if($hospital->type === 'public')
                    <span class="badge bg-success">Public</span>
                @else
                    <span class="badge bg-warning text-dark">Privé</span>
                @endif
            </div>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning btn-sm flex-fill text-white">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form method="POST" action="{{ route('hospitals.destroy', $hospital) }}"
                      onsubmit="return confirm('Supprimer cet hôpital ?')">
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Type d'établissement</label>
                        <p class="mb-0">
                            @if($hospital->type === 'public')
                                <span class="badge bg-success">Public</span>
                            @else
                                <span class="badge bg-warning text-dark">Privé</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Gouvernorat</label>
                        <p class="mb-0">{{ $hospital->gouvernorat }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Ville</label>
                        <p class="mb-0">{{ $hospital->ville }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Services disponibles</label>
                        <p class="mb-0">
                            @if($hospital->urgence)
                                <span class="badge bg-danger">Urgence</span>
                            @endif
                            @if($hospital->maternite)
                                <span class="badge bg-info">Maternité</span>
                            @endif
                            @if($hospital->chirurgie)
                                <span class="badge bg-secondary">Chirurgie</span>
                            @endif
                            @if(!$hospital->urgence && !$hospital->maternite && !$hospital->chirurgie)
                                <span class="text-muted small">Consultation générale</span>
                            @endif
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Téléphone</label>
                        <p class="mb-0">{{ $hospital->telephone ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Email</label>
                        <p class="mb-0">{{ $hospital->email ?? '—' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Latitude</label>
                        <p class="mb-0">{{ $hospital->latitude ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-semibold">Longitude</label>
                        <p class="mb-0">{{ $hospital->longitude ?? '—' }}</p>
                    </div>
                </div>
                @if($hospital->description)
                    <hr>
                    <div>
                        <label class="text-muted small fw-semibold">Description</label>
                        <p class="mb-0">{{ $hospital->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
