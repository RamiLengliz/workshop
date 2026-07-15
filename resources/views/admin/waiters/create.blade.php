@extends('layouts.admin')

@section('title', 'Nouveau serveur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Nouveau serveur</h2>
    <a href="{{ route('admin.waiters.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card shadow-sm" style="max-width:500px;">
    <div class="card-body p-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.waiters.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control"
                       required minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-check-fill me-1"></i> Créer le serveur
            </button>
        </form>
    </div>
</div>
@endsection
