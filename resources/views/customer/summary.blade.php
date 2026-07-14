@extends('layouts.customer')

@section('title', 'Récapitulatif - Workshop Bistro')

@section('content')
    @include('customer.partials.simple-header', ['table' => $table])

    <div class="page-wrap">
        <h1 class="page-title">Récapitulatif de la commande</h1>

        @if (session('error'))
            <div class="alert-box alert-error">{{ session('error') }}</div>
        @endif

        @if ($items->isEmpty())
            <div class="empty-state">
                <div class="icon">🛒</div>
                <p>Votre panier est vide.</p>
                <div style="display:flex;gap:14px;justify-content:center;margin-top:10px;flex-wrap:wrap;">
                    <a href="{{ route('customer.menu', $table) }}" class="btn-pink">
                        Voir le menu
                    </a>
                    <a href="{{ route('waiter.tables') }}" class="btn-outline-brown">
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        @else
            @foreach ($items as $item)
                <div class="cart-row">
                    <div style="flex:1;min-width:0;">
                        <div class="name">{{ $item->quantity }} x {{ $item->product->name }}</div>
                        @if (!empty($item->options))
                            <div class="item-options">
                                @foreach ($item->options as $choice)
                                    <span class="item-option-tag">{{ $choice }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div style="font-weight:600;white-space:nowrap;">{{ number_format($item->subtotal, 2) }} DT</div>
                </div>
            @endforeach

            <div class="cart-total-bar">
                <span>Total à payer</span>
                <span>{{ number_format($total, 2) }} DT</span>
            </div>

            <div style="display:flex;gap:14px;margin-top:24px;flex-wrap:wrap;">
                <a href="{{ route('customer.cart', $table) }}" class="btn-outline-brown">Modifier le panier</a>

                <form action="{{ route('customer.order.store', $table) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pink">Confirmer la commande</button>
                </form>
            </div>
        @endif
    </div>
@endsection
