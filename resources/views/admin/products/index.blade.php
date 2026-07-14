@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg"></i> Ajouter un produit
    </a>

    <form method="GET" class="d-flex gap-2">
        <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Disponible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="50" height="50" class="rounded object-fit-cover">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>{{ number_format($product->price, 2) }} DT</td>
                        <td>
                            @if ($product->available)
                                <span class="badge text-bg-success">Oui</span>
                            @else
                                <span class="badge text-bg-secondary">Non</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
@endsection
