{{-- Lightweight header for standalone pages (cart / summary / confirmation) --}}
@php
    $cupIcon = '<svg viewBox="440 150 380 320" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="22" stroke-linecap="round" stroke-linejoin="round">
        <path d="M470 300h230v150a115 115 0 0 1-115 115h0a115 115 0 0 1-115-115z"></path>
        <path d="M700 330h55a55 55 0 0 1 0 110h-55"></path>
        <path d="M520 235c-12-18 12-33 0-52M585 235c-12-18 12-33 0-52M650 235c-12-18 12-33 0-52"></path>
    </svg>';
@endphp

<header class="wb-header">
    <div class="wb-header-row">
        <a href="{{ route('customer.menu', $table) }}" class="wb-brand">
            <span style="color:var(--ink);display:inline-flex;">{!! $cupIcon !!}</span>
            <div class="wb-brand-text">
                <span class="name">WORKSHOP BISTRO</span>
                <span class="tagline">It feels like home</span>
            </div>
        </a>

        <div class="wb-header-actions">
            <span class="table-pill">Table {{ $table->number }}</span>
        </div>
    </div>
</header>
