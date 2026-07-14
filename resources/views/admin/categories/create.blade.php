@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('content')
<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom de la catégorie</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-dark">Enregistrer</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
