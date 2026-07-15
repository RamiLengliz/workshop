@extends('layouts.admin')

@section('title', 'Gestion des serveurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Serveurs</h2>
    <a href="{{ route('admin.waiters.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i> Nouveau serveur
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Créé le</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($waiters as $waiter)
                    <tr>
                        <td>{{ $waiter->id }}</td>
                        <td>{{ $waiter->name }}</td>
                        <td>{{ $waiter->email }}</td>
                        <td>{{ $waiter->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <form method="POST"
                                  action="{{ route('admin.waiters.destroy', $waiter) }}"
                                  onsubmit="return confirm('Supprimer ce serveur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucun serveur enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
