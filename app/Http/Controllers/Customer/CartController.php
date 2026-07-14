<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TableCafe;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(TableCafe $table)
    {
        $items = Cart::items($table->id);
        $total = Cart::total($table->id);

        return view('customer.cart', compact('table', 'items', 'total'));
    }

    public function add(Request $request, TableCafe $table)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $options = $request->input('options', []);
        if (!is_array($options)) {
            $options = [];
        }

        $product   = Product::find((int) $request->product_id);
        $surcharge = 0.0;

        if ($product && $product->options_config) {
            foreach ($product->options_config as $group) {
                $groupName  = $group['name'] ?? '';
                $noneValue  = $group['none_value'] ?? null;
                $selected   = $options[$groupName] ?? null;

                // Strip "none" selections — they carry no information
                if ($noneValue !== null && $selected === $noneValue) {
                    unset($options[$groupName]);
                    continue;
                }

                // Accumulate surcharge for real selections
                if ($selected && isset($group['surcharge']) && (float) $group['surcharge'] > 0) {
                    $surcharge += (float) $group['surcharge'];
                }
            }
        }

        Cart::add($table->id, (int) $request->product_id, $options, 1, $surcharge);

        return $this->respond($request, $table, 'Produit ajouté au panier.');
    }

    public function increase(Request $request, TableCafe $table)
    {
        $request->validate(['line_id' => 'required|string']);
        Cart::increase($table->id, $request->line_id);

        return $this->respond($request, $table);
    }

    public function decrease(Request $request, TableCafe $table)
    {
        $request->validate(['line_id' => 'required|string']);
        Cart::decrease($table->id, $request->line_id);

        return $this->respond($request, $table);
    }

    public function remove(Request $request, TableCafe $table)
    {
        $request->validate(['line_id' => 'required|string']);
        Cart::remove($table->id, $request->line_id);

        return $this->respond($request, $table, 'Produit retiré du panier.');
    }

    private function respond(Request $request, TableCafe $table, ?string $message = null)
    {
        if ($request->wantsJson()) {
            $items = Cart::items($table->id);
            $total = Cart::total($table->id);
            $count = Cart::count($table->id);

            return response()->json([
                'count' => $count,
                'total' => number_format($total, 2),
                'html'  => view('customer.partials.cart-drawer', compact('table', 'items', 'total'))->render(),
            ]);
        }

        return $message ? back()->with('success', $message) : back();
    }
}
