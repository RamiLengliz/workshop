<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TableCafe;
use App\Support\Cart;

class OrderController extends Controller
{
    public function summary(TableCafe $table)
    {
        $items = Cart::items($table->id);
        $total = Cart::total($table->id);

        return view('customer.summary', compact('table', 'items', 'total'));
    }

    public function store(TableCafe $table)
    {
        $items = Cart::items($table->id);

        if ($items->isEmpty()) {
            return redirect()->route('customer.menu', $table)->with('error', 'Votre panier est vide.');
        }

        $order = Order::create([
            'table_id' => $table->id,
            'total' => Cart::total($table->id),
            'status' => 'pending',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product->id,
                'quantity'   => $item->quantity,
                'price'      => $item->unit_price,   // base + surcharge
                'options'    => !empty($item->options) ? $item->options : null,
            ]);
        }

        Cart::clear($table->id);

        $table->update(['status' => 'occupied']);

        return redirect()->route('customer.order.confirmation', ['table' => $table, 'order' => $order]);
    }

    public function confirmation(TableCafe $table, Order $order)
    {
        $order->load('items.product');

        return view('customer.confirmation', compact('table', 'order'));
    }
}
