@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-body">
        @if ($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="100" class="rounded mb-3">
        @endif
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-select" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Prix (DT)</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image (laisser vide pour conserver l'actuelle)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="available" value="1" class="form-check-input" id="available" @checked(old('available', $product->available))>
                <label class="form-check-label" for="available">Disponible</label>
            </div>
            <button type="submit" class="btn btn-dark">Mettre à jour</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
