<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare – @yield('title', 'Accueil')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; }
        .sidebar {
            min-height: 100vh;
            background: #1a2340;
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .brand {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 0 20px 20px;
            border-bottom: 1px solid #2d3a5e;
        }
        .sidebar .nav-link {
            color: #a0aec0;
            padding: 10px 20px;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: #2d3a5e;
        }
        .sidebar .nav-link i { font-size: 1.1rem; }
        .main-content {
            margin-left: 240px;
            padding: 30px;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 30px;
            margin-left: 240px;
            position: sticky;
            top: 0;
            z-index: 99;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
        .badge-planifie  { background: #ffc107; color: #000; }
        .badge-confirme  { background: #198754; color: #fff; }
        .badge-annule    { background: #dc3545; color: #fff; }
        .badge-effectue  { background: #6c757d; color: #fff; }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="brand"><i class="bi bi-heart-pulse-fill text-danger"></i> MediCare</div>
    <nav class="nav flex-column mt-3">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a href="{{ route('patients.index') }}"
           class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Patients
        </a>
        <a href="{{ route('medecins.index') }}"
           class="nav-link {{ request()->routeIs('medecins.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Médecins
        </a>
        <a href="{{ route('rendezvous.index') }}"
           class="nav-link {{ request()->routeIs('rendezvous.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Rendez-vous
        </a>
        <a href="{{ route('medicaments.index') }}"
           class="nav-link {{ request()->routeIs('medicaments.*') ? 'active' : '' }}">
            <i class="bi bi-capsule"></i> Médicaments
        </a>
        <a href="{{ route('hospitals.index') }}"
           class="nav-link {{ request()->routeIs('hospitals.*') ? 'active' : '' }}">
            <i class="bi bi-hospital"></i> Hôpitaux
        </a>
        <hr style="border-color:#2d3a5e; margin: 8px 20px;">
        <a href="{{ route('chatbot.index') }}"
           class="nav-link {{ request()->routeIs('chatbot.*') ? 'active' : '' }}">
            <i class="bi bi-robot"></i> Chatbot IA
        </a>
    </nav>
</div>

{{-- Topbar --}}
<div class="topbar">
    <h6 class="mb-0 fw-semibold">@yield('title', 'Tableau de bord')</h6>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted small">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

{{-- Contenu principal --}}
<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
