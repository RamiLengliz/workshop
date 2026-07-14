<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Session cart with per-line options + surcharge support.
 *
 * Structure in session:
 *   cart.table.{tableId} => [
 *     line_id => [
 *       'product_id' => int,
 *       'qty'        => int,
 *       'options'    => ['Group name' => 'Chosen value', ...],
 *       'surcharge'  => float,   // extra DT per unit (e.g. +1 for arôme)
 *     ],
 *     ...
 *   ]
 *
 * line_id = md5(productId . json_encode(ksorted options))
 */
class Cart
{
    private static function key(int $tableId): string
    {
        return "cart.table.{$tableId}";
    }

    public static function lineId(int $productId, array $options = []): string
    {
        ksort($options);
        return md5($productId . json_encode($options));
    }

    /** Raw cart: [line_id => ['product_id', 'qty', 'options', 'surcharge']] */
    public static function raw(int $tableId): array
    {
        $cart = session(self::key($tableId), []);

        // Detect old format [product_id => qty] (plain integer values) — clear it.
        if (!empty($cart) && is_int(reset($cart))) {
            session()->forget(self::key($tableId));
            return [];
        }

        return $cart;
    }

    private static function save(int $tableId, array $cart): void
    {
        $cart = array_filter($cart, fn ($line) => $line['qty'] > 0);
        session([self::key($tableId) => $cart]);
    }

    public static function add(int $tableId, int $productId, array $options = [], int $qty = 1, float $surcharge = 0.0): void
    {
        $cart   = self::raw($tableId);
        $lineId = self::lineId($productId, $options);

        if (isset($cart[$lineId])) {
            $cart[$lineId]['qty'] += $qty;
        } else {
            ksort($options);
            $cart[$lineId] = [
                'product_id' => $productId,
                'qty'        => $qty,
                'options'    => $options,
                'surcharge'  => $surcharge,
            ];
        }

        self::save($tableId, $cart);
    }

    public static function increase(int $tableId, string $lineId): void
    {
        $cart = self::raw($tableId);
        if (isset($cart[$lineId])) {
            $cart[$lineId]['qty'] += 1;
            self::save($tableId, $cart);
        }
    }

    public static function decrease(int $tableId, string $lineId): void
    {
        $cart = self::raw($tableId);
        if (isset($cart[$lineId])) {
            $cart[$lineId]['qty'] -= 1;
            self::save($tableId, $cart);
        }
    }

    public static function remove(int $tableId, string $lineId): void
    {
        $cart = self::raw($tableId);
        unset($cart[$lineId]);
        self::save($tableId, $cart);
    }

    public static function clear(int $tableId): void
    {
        session()->forget(self::key($tableId));
    }

    /** Cart lines enriched with product, qty, options, surcharge, unit_price, subtotal. */
    public static function items(int $tableId): Collection
    {
        $cart = self::raw($tableId);

        if (empty($cart)) {
            return collect();
        }

        $productIds = array_unique(array_column($cart, 'product_id'));
        $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return collect($cart)
            ->map(function ($line, $lineId) use ($products) {
                $product = $products->get($line['product_id']);
                if (!$product) return null;

                $surcharge  = (float) ($line['surcharge'] ?? 0);
                $unitPrice  = round((float) $product->price + $surcharge, 2);

                return (object) [
                    'line_id'    => $lineId,
                    'product'    => $product,
                    'quantity'   => $line['qty'],
                    'options'    => $line['options'] ?? [],
                    'surcharge'  => $surcharge,
                    'unit_price' => $unitPrice,
                    'subtotal'   => round($unitPrice * $line['qty'], 2),
                ];
            })
            ->filter()
            ->values();
    }

    public static function count(int $tableId): int
    {
        return array_sum(array_column(self::raw($tableId), 'qty'));
    }

    public static function total(int $tableId): float
    {
        return round(self::items($tableId)->sum('subtotal'), 2);
    }
}
