<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TableCafe;
use App\Support\Cart;

class WaiterController extends Controller
{
    public function tables()
    {
        $tables = TableCafe::with(['orders' => function ($query) {
            $query->where('status', 'pending')->latest();
        }])->orderBy('number')->get();

        return view('waiter.tables', compact('tables'));
    }

    public function selectTable(TableCafe $table)
    {
        $table->update(['status' => 'occupied']);

        return redirect()->route('customer.menu', $table);
    }

    public function freeTable(TableCafe $table)
    {
        Cart::clear($table->id);
        $table->update(['status' => 'free']);

        return redirect()->route('waiter.tables')->with('success', "Table {$table->number} libérée.");
    }

    public function pendingOrders()
    {
        $orders = Order::with(['table', 'items.product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('waiter.orders.index', compact('orders'));
    }

    public function review(Order $order)
    {
        $order->load(['table', 'items.product']);

        return view('waiter.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        $order->update(['status' => 'confirmed']);

        return redirect()->route('waiter.orders.index')->with('success', "Commande #{$order->id} confirmée.");
    }
}
