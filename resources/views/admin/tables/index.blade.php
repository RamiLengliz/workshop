@extends('layouts.admin')

@section('title', 'Tables')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.tables.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg"></i> Ajouter une table
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    <tr>
                        <td>Table {{ $table->number }}</td>
                        <td>
                            @if ($table->status === 'free')
                                <span class="badge text-bg-success">Libre</span>
                            @else
                                <span class="badge text-bg-danger">Occupée</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette table ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Aucune table.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
