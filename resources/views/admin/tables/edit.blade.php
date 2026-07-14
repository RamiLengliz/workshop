@extends('layouts.admin')

@section('title', 'Modifier la table')

@section('content')
<div class="card" style="max-width: 400px;">
    <div class="card-body">
        <form action="{{ route('admin.tables.update', $table) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Numéro de table</label>
                <input type="number" name="number" min="1" class="form-control" value="{{ old('number', $table->number) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="free" @selected(old('status', $table->status) === 'free')>Libre</option>
                    <option value="occupied" @selected(old('status', $table->status) === 'occupied')>Occupée</option>
                </select>
            </div>
            <button type="submit" class="btn btn-dark">Mettre à jour</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
@endsection
