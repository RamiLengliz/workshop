@extends('layouts.waiter')

@section('title', 'Tables')

@section('content')
    <h3 class="mb-4">Sélectionner une table</h3>

    <div class="row g-3">
        @foreach ($tables as $table)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100 text-center {{ $table->status === 'occupied' ? 'border-warning' : 'border-success' }}">
                    <div class="card-body">
                        <i class="bi bi-grid-3x3-gap-fill" style="font-size:2rem;"></i>
                        <h4 class="mt-2">Table {{ $table->number }}</h4>

                        <span class="badge {{ $table->status === 'occupied' ? 'bg-warning text-dark' : 'bg-success' }} mb-2">
                            {{ $table->status === 'occupied' ? 'Occupée' : 'Libre' }}
                        </span>

                        @if ($table->orders->isNotEmpty())
                            <div class="small text-danger fw-semibold mb-2">
                                <i class="bi bi-bell-fill"></i> {{ $table->orders->count() }} commande(s) en attente
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-2 mt-2">
                            <form action="{{ route('waiter.tables.select', $table) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                    <i class="bi bi-tablet"></i> Ouvrir le menu
                                </button>
                            </form>

                            @if ($table->status === 'occupied')
                                <form action="{{ route('waiter.tables.free', $table) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                                        Libérer la table
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
