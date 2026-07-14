@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="card" style="max-width: 500px;">
    <div class="card-body">
        @if ($category->image)
            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="80" class="rounded mb-3">
        @endif
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom de la catégorie</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image (laisser vide pour conserver l'actuelle)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-dark">Mettre à jour</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
