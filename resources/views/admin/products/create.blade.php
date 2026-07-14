@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Prix (DT)</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="available" value="1" class="form-check-input" id="available" checked>
                <label class="form-check-label" for="available">Disponible</label>
            </div>
            <button type="submit" class="btn btn-dark">Enregistrer</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
