@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg"></i> Ajouter une catégorie
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Produits</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="50" height="50" class="rounded object-fit-cover">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
