<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration') - Café Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f5f7; }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.08);
        }
        .sidebar .navbar-brand {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="sidebar p-3" style="width: 240px;">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-block mb-4 fs-5 fw-bold">
            <i class="bi bi-cup-hot"></i> Café Admin
        </a>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags me-2"></i> Catégories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-egg-fried me-2"></i> Produits
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tables.index') }}" class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap me-2"></i> Tables
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt me-2"></i> Commandes
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.waiters.index') }}" class="nav-link {{ request()->routeIs('admin.waiters.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Serveurs
                </a>
            </li>
        </ul>

        <hr class="text-secondary">

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-left me-2"></i> Déconnexion
            </button>
        </form>
    </nav>

    <main class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">@yield('title', 'Tableau de bord')</h2>
            @auth
                <span class="text-muted">{{ auth()->user()->name }}</span>
            @endauth
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
