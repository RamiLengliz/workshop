@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
<form method="GET" class="mb-3 d-flex gap-2">
    <select name="status" class="form-select" style="max-width: 220px;" onchange="this.form.submit()">
        <option value="">Tous les statuts</option>
        @foreach (['pending', 'confirmed', 'preparing', 'served', 'cancelled'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Table</th>
                    <th>Articles</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->table->number ?? '—' }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>{{ number_format($order->total, 2) }} DT</td>
                        <td><span class="badge text-bg-info">{{ $order->status }}</span></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-3">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $orders->links() }}
</div>
@endsection
