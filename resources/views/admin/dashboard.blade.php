@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-dark">
            <div class="card-body">
                <div class="text-uppercase small">Catégories</div>
                <div class="fs-3 fw-bold">{{ $stats['categories'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-secondary">
            <div class="card-body">
                <div class="text-uppercase small">Produits</div>
                <div class="fs-3 fw-bold">{{ $stats['products'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success">
            <div class="card-body">
                <div class="text-uppercase small">Tables</div>
                <div class="fs-3 fw-bold">{{ $stats['tables'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning">
            <div class="card-body">
                <div class="text-uppercase small">Commandes en attente</div>
                <div class="fs-3 fw-bold">{{ $stats['pendingOrders'] }} / {{ $stats['orders'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Dernières commandes</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Table</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->table->number ?? '—' }}</td>
                        <td>{{ number_format($order->total, 2) }} DT</td>
                        <td><span class="badge text-bg-info">{{ $order->status }}</span></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Voir</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Aucune commande pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
