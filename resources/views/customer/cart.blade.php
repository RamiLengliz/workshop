@extends('layouts.customer')

@section('title', 'Mon Panier - Workshop Bistro')

@section('content')
    @include('customer.partials.simple-header', ['table' => $table])

    <div class="page-wrap">
        <h1 class="page-title">Mon Panier</h1>

        @if (session('success'))
            <div class="alert-box alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-box alert-error">{{ session('error') }}</div>
        @endif

        @if ($items->isEmpty())
            <div class="empty-state">
                <div class="icon">🛒</div>
                <p>Votre panier est vide pour le moment.</p>
                <div style="display:flex;gap:14px;justify-content:center;margin-top:10px;flex-wrap:wrap;">
                    <a href="{{ route('customer.menu', $table) }}" class="btn-pink">Voir le menu</a>
                    <a href="{{ route('waiter.tables') }}" class="btn-outline-brown">Retour à l'accueil</a>
                </div>
            </div>
        @else
            @foreach ($items as $item)
                <div class="cart-row">
                    <div style="flex:1;min-width:0;">
                        <div class="name">{{ $item->product->name }}</div>
                        @if (!empty($item->options))
                            <div class="item-options">
                                @foreach ($item->options as $choice)
                                    <span class="item-option-tag">{{ $choice }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div style="font-size:0.85rem;color:var(--muted);margin-top:2px;">{{ number_format($item->unit_price, 2) }} DT</div>
                    </div>

                    <div class="stepper">
                        <form action="{{ route('customer.cart.decrease', $table) }}" method="POST">
                            @csrf
                            <input type="hidden" name="line_id" value="{{ $item->line_id }}">
                            <button type="submit" aria-label="Moins">&minus;</button>
                        </form>
                        <span style="min-width:16px;text-align:center;font-weight:600;font-size:14px;">{{ $item->quantity }}</span>
                        <form action="{{ route('customer.cart.increase', $table) }}" method="POST">
                            @csrf
                            <input type="hidden" name="line_id" value="{{ $item->line_id }}">
                            <button type="submit" aria-label="Plus">+</button>
                        </form>
                    </div>

                    <div style="text-align:right;min-width:90px;">
                        <div style="font-weight:600;">{{ number_format($item->subtotal, 2) }} DT</div>
                        <form action="{{ route('customer.cart.remove', $table) }}" method="POST">
                            @csrf
                            <input type="hidden" name="line_id" value="{{ $item->line_id }}">
                            <button type="submit" style="background:none;border:none;color:var(--accent-dark);font-size:0.78rem;cursor:pointer;text-decoration:underline;">
                                Retirer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="cart-total-bar">
                <span>Total</span>
                <span>{{ number_format($total, 2) }} DT</span>
            </div>

            <div style="display:flex;gap:14px;margin-top:24px;flex-wrap:wrap;">
                <a href="{{ route('customer.menu', $table) }}" class="btn-outline-brown">Continuer mes achats</a>
                <a href="{{ route('customer.summary', $table) }}" class="btn-pink">Valider ma commande</a>
            </div>
        @endif
    </div>
@endsection
