@extends('layouts.customer')

@section('title', 'Commande confirmée - Workshop Bistro')

@section('content')
    @include('customer.partials.simple-header', ['table' => $table])

    <div class="page-wrap">
        <div class="confirmation-box">
            <div class="check">✓</div>
            <h2>Merci ! Votre commande a été envoyée.</h2>
            <p style="color:var(--muted);">Un serveur va confirmer votre commande sous peu.</p>

            <div style="max-width:420px;margin:30px auto 0;text-align:left;">
                @foreach ($order->items as $item)
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
                        <div style="font-weight:600;white-space:nowrap;">{{ number_format($item->price * $item->quantity, 2) }} DT</div>
                    </div>
                @endforeach

                <div class="cart-total-bar">
                    <span>Total</span>
                    <span>{{ number_format($order->total, 2) }} DT</span>
                </div>
            </div>

            <div style="display:flex;gap:14px;justify-content:center;margin-top:30px;flex-wrap:wrap;">
                <a href="{{ route('customer.menu', $table) }}" class="btn-outline-brown">
                    Retour au menu
                </a>
                <a href="{{ route('waiter.tables') }}" class="btn-pink">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
@endsection
