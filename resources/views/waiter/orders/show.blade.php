@extends('layouts.waiter')

@section('title', 'Commande #' . $order->id)

@section('content')
    <a href="{{ route('waiter.orders.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Commande #{{ $order->id }} &middot; Table {{ $order->table->number }}</h4>
            <p class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Qté</th>
                        <th class="text-end">Prix</th>
                        <th class="text-end">Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <div>{{ $item->product->name }}</div>
                                @if (!empty($item->options))
                                    <div class="mt-1">
                                        @foreach ($item->options as $choice)
                                            <span class="badge bg-secondary" style="font-size:11px;font-weight:400;">{{ $choice }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price, 2) }} DT</td>
                            <td class="text-end">{{ number_format($item->price * $item->quantity, 2) }} DT</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end">{{ number_format($order->total, 2) }} DT</th>
                    </tr>
                </tfoot>
            </table>

            @if ($order->status === 'pending')
                <form action="{{ route('waiter.orders.confirm', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Confirmer la commande
                    </button>
                </form>
            @else
                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
            @endif
        </div>
    </div>
@endsection
