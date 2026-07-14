@extends('layouts.customer')

@section('title', 'Menu - Workshop Bistro')

@section('content')
    @php
        $cupIcon = '<svg viewBox="440 150 380 320" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="22" stroke-linecap="round" stroke-linejoin="round">
            <path d="M470 300h230v150a115 115 0 0 1-115 115h0a115 115 0 0 1-115-115z"></path>
            <path d="M700 330h55a55 55 0 0 1 0 110h-55"></path>
            <path d="M520 235c-12-18 12-33 0-52M585 235c-12-18 12-33 0-52M650 235c-12-18 12-33 0-52"></path>
        </svg>';
    @endphp

    <header class="wb-header">
        <div class="wb-header-row">
            <div class="wb-brand">
                <span style="color:var(--ink);display:inline-flex;">{!! $cupIcon !!}</span>
                <div class="wb-brand-text">
                    <span class="name">WORKSHOP BISTRO</span>
                    <span class="tagline">It feels like home</span>
                </div>
            </div>

            <div class="wb-header-actions">
                <span class="table-pill">Table {{ $table->number }}</span>
                <a href="{{ route('customer.cart', $table) }}" class="cart-btn js-open-cart">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span>Panier</span>
                    <span class="badge" id="cartBadge">{{ $cartCount }}</span>
                </a>
            </div>
        </div>

        <nav class="wb-chips">
            @foreach ($categories as $category)
                <a href="#cat-{{ $category->slug }}">{{ $category->name }}</a>
            @endforeach
        </nav>
    </header>

    @if (session('error'))
        <div class="page-wrap" style="max-width:1180px;padding-bottom:0;">
            <div class="alert-box alert-error">{{ session('error') }}</div>
        </div>
    @endif
    @if (session('success'))
        <div class="page-wrap" style="max-width:1180px;padding-bottom:0;">
            <div class="alert-box alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <section class="wb-hero">
        <div class="wb-hero-text">
            <span class="wb-hero-eyebrow">Commande à table &middot; Table {{ $table->number }}</span>
            <h1>IT FEELS<br>LIKE HOME</h1>
            <p>Petit-déjeuner, cafés de spécialité, crêpes, gaufres &amp; paninis — composez votre commande, un serveur s'occupe du reste.</p>
            <div class="wb-hero-actions">
                <a href="#cat-{{ $categories->first()->slug ?? '' }}" class="btn-dark">Voir le menu</a>
                <a href="{{ route('customer.cart', $table) }}" class="btn-ghost js-open-cart">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Mon panier
                </a>
            </div>
        </div>
        <div class="wb-hero-img">
            <div class="frame">
                <span style="color:#FCF6E9;display:inline-flex;">{!! $cupIcon !!}</span>
            </div>
        </div>
    </section>

    <main class="wb-menu">
        @foreach ($categories as $category)
            <section id="cat-{{ $category->slug }}" class="wb-category">
                <div class="wb-category-head">
                    <h2 class="wb-category-title">{{ $category->name }}</h2>
                    @if ($category->note)
                        <p class="wb-category-note">{{ $category->note }}</p>
                    @endif
                </div>

                <div class="product-grid">
                    @foreach ($category->products as $product)
                        <div class="product-card">
                            <div class="product-photo-wrap">
                                <div class="product-photo">
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <span class="product-photo-fallback">{!! $category->icon !!}</span>
                                    @endif
                                </div>

                                @if ($product->options_config)
                                    {{-- Produit avec options : ouvre le modal --}}
                                    <div class="product-add-form">
                                        <button type="button"
                                                class="add-btn js-options-btn"
                                                aria-label="Personnaliser"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ $product->price }}"
                                                data-cart-url="{{ route('customer.cart.add', $table) }}"
                                                data-options="{{ json_encode($product->options_config) }}">+</button>
                                    </div>
                                @else
                                    {{-- Produit simple : ajout direct --}}
                                    <form action="{{ route('customer.cart.add', $table) }}" method="POST" class="js-add-form product-add-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="add-btn" aria-label="Ajouter">+</button>
                                    </form>
                                @endif
                            </div>

                            <div class="product-info">
                                <div class="name">{{ $product->name }}</div>
                                @if ($product->description)
                                    <div class="desc">{{ $product->description }}</div>
                                @endif
                                <div class="product-price">{{ number_format($product->price, 2) }}<span class="dt">DT</span></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>

    <footer class="wb-footer">
        <div class="wb-footer-row">
            <div>
                <div class="wb-footer-brand">WORKSHOP BISTRO</div>
                <div class="wb-footer-tagline">This is my happy place</div>
            </div>
            <div class="wb-footer-info">
                <span>📍 Table {{ $table->number }} &middot; service en salle</span>
                <span>☕ Commande envoyée directement en cuisine</span>
            </div>
        </div>
    </footer>

    {{-- Options modal --}}
    <div id="optionsModal" class="options-modal-overlay" role="dialog" aria-modal="true">
        <div class="options-modal">
            <div class="options-modal-head">
                <div>
                    <h3 id="optionsModalTitle"></h3>
                    <div class="options-modal-price" id="optionsModalPrice" style="display:none;"></div>
                </div>
                <button type="button" id="optionsModalClose" class="options-modal-close" aria-label="Fermer">&times;</button>
            </div>
            <div class="options-modal-body">
                <form id="optionsModalForm" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="optionsModalProductId">
                    <div id="optionsModalGroups"></div>
                    <button type="submit" class="options-modal-submit">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Cart drawer --}}
    <div class="drawer-overlay" id="cartDrawerOverlay">
        <aside class="drawer-panel" id="cartDrawerPanel">
            <div class="drawer-head">
                <span class="title">Mon panier</span>
                <button type="button" class="drawer-close js-close-cart" aria-label="Fermer">&times;</button>
            </div>

            <div class="drawer-body" id="cartDrawerBody">
                @include('customer.partials.cart-drawer', ['table' => $table, 'items' => $cartItems])
            </div>

            <div class="drawer-foot" id="cartDrawerTotalRow" style="{{ $cartCount > 0 ? '' : 'display:none;' }}">
                <div class="drawer-total-row">
                    <span class="label">Total</span>
                    <span class="amount" id="cartDrawerTotalAmount">{{ number_format($cartTotal, 2) }}<span class="dt">DT</span></span>
                </div>
                <a href="{{ route('customer.summary', $table) }}" class="btn-checkout" style="display:block;text-align:center;">
                    Commander &middot; {{ number_format($cartTotal, 2) }} DT
                </a>
            </div>
        </aside>
    </div>
@endsection
