{{-- Rendered both on initial page load and via AJAX (CartController) --}}
@if ($items->isEmpty())
    <div class="drawer-empty">
        <div class="icon">☕</div>
        <div class="lead">Votre panier est vide</div>
        <div>Ajoutez vos gourmandises préférées depuis le menu.</div>
        <a href="{{ route('waiter.tables') }}" class="btn-outline-brown" style="display:inline-block;margin-top:18px;">
            Retour à l'accueil
        </a>
    </div>
@else
    @foreach ($items as $item)
        <div class="drawer-line">
            <div style="flex:1;min-width:0;">
                <div class="name">{{ $item->product->name }}</div>
                @if (!empty($item->options))
                    <div class="item-options">
                        @foreach ($item->options as $choice)
                            <span class="item-option-tag">{{ $choice }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="sub">{{ number_format($item->unit_price, 2) }} DT &times; {{ $item->quantity }}</div>
            </div>

            <div class="stepper">
                <form action="{{ route('customer.cart.decrease', $table) }}" method="POST" class="js-cart-form">
                    @csrf
                    <input type="hidden" name="line_id" value="{{ $item->line_id }}">
                    <button type="submit" aria-label="Moins">&minus;</button>
                </form>
                <span style="min-width:16px;text-align:center;font-weight:600;font-size:14px;">{{ $item->quantity }}</span>
                <form action="{{ route('customer.cart.increase', $table) }}" method="POST" class="js-cart-form">
                    @csrf
                    <input type="hidden" name="line_id" value="{{ $item->line_id }}">
                    <button type="submit" aria-label="Plus">+</button>
                </form>
            </div>

            <div class="line-total">{{ number_format($item->subtotal, 2) }}</div>
        </div>
    @endforeach
@endif
