<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TableCafe;
use App\Support\Cart;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(TableCafe $table)
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('available', true)->orderBy('id');
        }])->where('visible', true)->orderBy('id')->get()
            ->filter(fn ($category) => $category->products->isNotEmpty())
            ->values()
            ->map(function ($category) {
                $category->slug = Str::slug($category->name);
                $category->icon = $this->iconFor($category->name);

                return $category;
            });

        $cartItems = Cart::items($table->id);
        $cartCount = Cart::count($table->id);
        $cartTotal = Cart::total($table->id);

        return view('customer.menu', compact('table', 'categories', 'cartItems', 'cartCount', 'cartTotal'));
    }

    /**
     * Default placeholder icon shown for products without an uploaded photo,
     * picked per category so the menu doesn't look like one generic cup everywhere.
     */
    private function iconFor(string $categoryName): string
    {
        $svg = fn (string $inner) => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';

        $icons = [
            'Petit-déj' => $svg('<path d="M3 14c1-7 7-11 12-9 3 1.3 4 4 3 5-1.3-1.6-3.4-2-5-1 2 .6 3 2 2.7 3.4-1.5-1-3-1-4 0 1.3.2 2 1 2 2-2 .3-3.6-.3-4.5-1.5C8 14 5.5 15 3 14Z"></path>'),

            'Coffee' => '<svg viewBox="440 150 380 320" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="22" stroke-linecap="round" stroke-linejoin="round">
                <path d="M470 300h230v150a115 115 0 0 1-115 115h0a115 115 0 0 1-115-115z"></path>
                <path d="M700 330h55a55 55 0 0 1 0 110h-55"></path>
                <path d="M520 235c-12-18 12-33 0-52M585 235c-12-18 12-33 0-52M650 235c-12-18 12-33 0-52"></path>
            </svg>',

            'Macchiato & Café glacé' => $svg('<path d="M6 7h12l-1.3 12.5a1 1 0 0 1-1 .9H8.3a1 1 0 0 1-1-.9L6 7Z"></path><path d="M5 7h14"></path><path d="M14 3 17 7"></path><path d="M9 11h6M9.4 15h5.2"></path>'),

            'Thés' => $svg('<path d="M3 9h14v5a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V9Z"></path><path d="M17 10h2a2 2 0 1 1 0 4h-2"></path><path d="M8 2c-1 1-1 2 0 3M12 2c-1 1-1 2 0 3"></path>'),

            'Frappuccino' => $svg('<path d="M7 8h10l-1 12H8L7 8Z"></path><path d="M6 8h12"></path><path d="M13 4v6"></path><path d="M9 12h6M9.5 16h5"></path>'),

            'Chocolat chaud & glacé' => $svg('<path d="M4 9h12v6a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V9Z"></path><path d="M16 11h2a2 2 0 1 1 0 4h-2"></path><path d="M7 9c0-2 1-2 1-4M11 9c0-2 1-2 1-4"></path>'),

            'Milkshakes' => $svg('<path d="M8 6h8l-1.2 13.5a1 1 0 0 1-1 .9h-3.6a1 1 0 0 1-1-.9L8 6Z"></path><path d="M7 6h10"></path><circle cx="12" cy="4" r="1.4"></circle><path d="M16 3.5 14 6M9 10h6M9.4 14h5.2"></path>'),

            'Mojitos' => $svg('<path d="M6 4h12l-2.2 14a1 1 0 0 1-1 .9h-5.6a1 1 0 0 1-1-.9L6 4Z"></path><path d="M5 4h14"></path><path d="M9 9c2 1 4 1 6 0"></path><path d="M16 4 19 1"></path>'),

            'Smoothies' => $svg('<path d="M7 5h10l-1.5 14.5a1 1 0 0 1-1 .9H9.5a1 1 0 0 1-1-.9L7 5Z"></path><path d="M6.3 5h11.4"></path><path d="M15 3 17 5"></path><path d="M9 9.5h6"></path>'),

            'Classics' => $svg('<path d="M10 2h4v3l1.5 2v13a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V7L10 5V2Z"></path><path d="M9 11h6"></path>'),

            'Crêpes sucrées' => $svg('<path d="M3 14c0-5 4-9 9-9s9 4 9 9"></path><path d="M3 14h18"></path><path d="M7 14c1-2 2-3 2-5M12 14c1-3 2-4 2-7M17 14c1-2 1.5-3 1.5-4.5"></path>'),

            'Gaufres sucrées' => $svg('<rect x="4" y="4" width="16" height="16" rx="2"></rect><path d="M4 9h16M4 14h16M9 4v16M14 4v16"></path>'),

            'Crêpes salées' => $svg('<path d="M12 3 21 19H3L12 3Z"></path><path d="M8 14h8M9.5 17h5"></path>'),

            'Paninis' => $svg('<path d="M3 11h18l-1 3a3 3 0 0 1-3 2H7a3 3 0 0 1-3-2l-1-3Z"></path><path d="M4 11c1-4 5-7 8-7s7 3 8 7"></path><path d="M7 11c.5-2 2-3 5-3s4.5 1 5 3"></path>'),

            'Omelettes' => $svg('<ellipse cx="12" cy="13" rx="8" ry="6"></ellipse><circle cx="12" cy="13" r="2.6"></circle><path d="M20 12c1.5 0 2.5-.7 2.5-1.6"></path>'),
        ];

        return $icons[$categoryName] ?? $svg('<path d="M5 9h11v6a5 5 0 0 1-5 5h-1a5 5 0 0 1-5-5V9Z"></path><path d="M16 11h2a2 2 0 1 1 0 4h-2"></path>');
    }
}
