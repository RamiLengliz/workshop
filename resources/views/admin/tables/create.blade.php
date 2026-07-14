@extends('layouts.admin')

@section('title', 'Ajouter une table')

@section('content')
<div class="card" style="max-width: 400px;">
    <div class="card-body">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Numéro de table</label>
                <input type="number" name="number" min="1" class="form-control" value="{{ old('number') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="free" @selected(old('status', 'free') === 'free')>Libre</option>
                    <option value="occupied" @selected(old('status') === 'occupied')>Occupée</option>
                </select>
            </div>
            <button type="submit" class="btn btn-dark">Enregistrer</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
