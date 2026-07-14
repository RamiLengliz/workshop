@extends('layouts.admin')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Articles commandés</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Produit supprimé' }}</td>
                                <td>{{ number_format($item->price, 2) }} DT</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 2) }} DT</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>{{ number_format($order->total, 2) }} DT</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <p class="mb-1"><strong>Table :</strong> {{ $order->table->number ?? '—' }}</p>
                <p class="mb-1"><strong>Créée le :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Statut actuel :</strong> <span class="badge text-bg-info">{{ $order->status }}</span></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Mettre à jour le statut</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select mb-3">
                        @foreach (['pending', 'confirmed', 'preparing', 'served', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-dark w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.orders.index') }}" class="btn btn-link mt-3">&larr; Retour aux commandes</a>
@endsection
