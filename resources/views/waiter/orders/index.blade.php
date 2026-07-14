@extends('layouts.waiter')

@section('title', 'Commandes en attente')

@section('content')
    <h3 class="mb-4">Commandes en attente de confirmation</h3>

    @if ($orders->isEmpty())
        <p class="text-muted">Aucune commande en attente.</p>
    @else
        <div class="row g-3">
            @foreach ($orders as $order)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Table {{ $order->table->number }}
                                <span class="badge bg-secondary float-end">#{{ $order->id }}</span>
                            </h5>
                            <p class="text-muted small mb-2">{{ $order->created_at->format('H:i') }}</p>

                            <ul class="list-unstyled small mb-3">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->quantity }} x {{ $item->product->name }}</li>
                                @endforeach
                            </ul>

                            <p class="fw-bold">Total : {{ number_format($order->total, 2) }} DT</p>

                            <div class="d-flex gap-2">
                                <a href="{{ route('waiter.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Détails</a>
                                <form action="{{ route('waiter.orders.confirm', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Confirmer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
