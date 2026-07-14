<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Serveur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark" style="background-color:#3b2a20;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('waiter.tables') }}">
                <i class="bi bi-cup-hot-fill me-2"></i>Workshop Bistro &middot; Serveur
            </a>
            <div>
                <a href="{{ route('waiter.tables') }}" class="btn btn-outline-light btn-sm me-2">Tables</a>
                <a href="{{ route('waiter.orders.index') }}" class="btn btn-outline-light btn-sm">Commandes</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
