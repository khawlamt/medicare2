@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
{{-- Statistiques rapides --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center py-4">
            <i class="bi bi-people text-primary fs-2 mb-2"></i>
            <h6 class="text-muted small mb-1">Patients</h6>
            <h3 class="fw-bold mb-0">{{ $stats['patients'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-4">
            <i class="bi bi-person-badge text-success fs-2 mb-2"></i>
            <h6 class="text-muted small mb-1">Médecins</h6>
            <h3 class="fw-bold mb-0">{{ $stats['medecins'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-4">
            <i class="bi bi-calendar-check text-warning fs-2 mb-2"></i>
            <h6 class="text-muted small mb-1">Rendez-vous</h6>
            <h3 class="fw-bold mb-0">{{ $stats['rdv_total'] ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-4">
            <i class="bi bi-capsule text-danger fs-2 mb-2"></i>
            <h6 class="text-muted small mb-1">Alertes stock</h6>
            <h3 class="fw-bold mb-0">{{ $stats['alertes_stock'] ?? 0 }}</h3>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Conseils de santé --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3 fw-semibold">
                <i class="bi bi-lightbulb text-warning me-2"></i>Conseils pour la santé
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-droplet text-info me-2"></i>Buvez de l'eau régulièrement
                            </h6>
                            <p class="small text-muted mb-0">
                                Buvez au moins 8 verres d'eau par jour pour maintenir une bonne hydratation 
                                et soutenir vos fonctions corporelles.
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-heart text-danger me-2"></i>Faites de l'exercice régulièrement
                            </h6>
                            <p class="small text-muted mb-0">
                                30 minutes d'activité physique par jour réduisent le risque de maladies 
                                cardiovasculaires et améliorent votre bien-être mental.
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-moon-stars text-success me-2"></i>Dormez suffisamment
                            </h6>
                            <p class="small text-muted mb-0">
                                Visez 7 à 9 heures de sommeil par nuit pour favoriser la récupération et 
                                renforcer votre système immunitaire.
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-apple text-success me-2"></i>Mangez équilibré
                            </h6>
                            <p class="small text-muted mb-0">
                                Privilégiez les fruits, légumes, protéines et grains entiers pour une 
                                alimentation saine et énergisante.
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-graph-up text-primary me-2"></i>Contrôlez votre santé
                            </h6>
                            <p class="small text-muted mb-0">
                                Faites régulièrement des examens de santé pour détecter les problèmes 
                                éventuels à un stade précoce.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Carte des hôpitaux --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3 fw-semibold">
                <i class="bi bi-hospital text-danger me-2"></i>Hôpitaux et cliniques
            </div>
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-semibold">
                    <i class="bi bi-hospital text-danger me-2"></i>Hôpitaux et cliniques
                </span>
                <a href="{{ route('hospitals.create') }}" class="btn btn-sm btn-danger">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 400px; border-radius: 0 0 12px 12px;"></div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header bg-white py-2 fw-semibold">
                <small>Liste des établissements</small>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                <small class="fw-semibold">Liste des établissements</small>
                <a href="{{ route('hospitals.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-list"></i> Tous
                </a>
            </div>
            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                <div id="hospitals-list">
                    <p class="text-muted small text-center">Chargement des établissements...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts pour la carte --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte avec les coordonnées de la Tunisie
    const map = L.map('map').setView([35.8, 9.5], 7);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const hospitals = @json($hospitals);
    let listHTML = '';
    const bounds = L.latLngBounds();

    hospitals.forEach((hospital) => {
        const latitude = hospital.latitude ? parseFloat(hospital.latitude) : null;
        const longitude = hospital.longitude ? parseFloat(hospital.longitude) : null;

        if (latitude !== null && longitude !== null && !Number.isNaN(latitude) && !Number.isNaN(longitude)) {
            const marker = L.marker([latitude, longitude]).addTo(map);
            marker.bindPopup(`
                <strong>${hospital.nom}</strong><br>
                ${hospital.ville}, ${hospital.gouvernorat}
            `);
            bounds.extend([latitude, longitude]);
        }

        listHTML += `
            <div class="d-flex gap-1 mb-2 p-2 border-bottom align-items-center">
                <i class="bi bi-hospital text-danger flex-shrink-0"></i>
                <div style="flex: 1; min-width: 0;">
                    <h6 class="mb-0 small fw-semibold">${hospital.nom}</h6>
                    <p class="text-muted small mb-0">${hospital.ville}, ${hospital.gouvernorat}</p>
                </div>
                <div class="d-flex gap-1">
                    <a href="/hospitals/${hospital.id}" class="btn btn-sm btn-outline-info" title="Voir">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/hospitals/${hospital.id}/edit" class="btn btn-sm btn-outline-warning" title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="deleteHospital(${hospital.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });

    document.getElementById('hospitals-list').innerHTML = listHTML || '<p class="text-muted small text-center">Aucun hôpital enregistré</p>';

    if (bounds.isValid()) {
        map.fitBounds(bounds, { padding: [40, 40] });
    }

    window.deleteHospital = function(hospitalId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet hôpital ?')) {
            fetch(`/hospitals/${hospitalId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression');
                }
            }).catch(() => alert('Erreur de connexion'));
        }
    };

    window.zoomToHospital = function(lat, lng) {
        map.setView([lat, lng], 16);
    };
});
</script>

@endsection
