<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Serveur – Workshop Bistro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #3b2a20;
        }
        .login-card { max-width: 400px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card login-card mx-auto shadow">
        <div class="card-body p-4">
            <h3 class="text-center mb-1">
                <i class="bi bi-person-badge"></i> Espace Serveur
            </h3>
            <p class="text-center text-muted small mb-4">Workshop Bistro</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('waiter.login.attempt') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn w-100 text-white"
                        style="background-color:#3b2a20;">Se connecter</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
