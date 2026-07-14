<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Waiter\WaiterController;

Route::get('/', function () {
    return redirect()->route('waiter.tables');
});

/*
|--------------------------------------------------------------------------
| Admin (login required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('tables', TableController::class);

        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Waiter (no login required - shared staff device)
|--------------------------------------------------------------------------
*/
Route::prefix('waiter')->name('waiter.')->group(function () {
    Route::get('/', [WaiterController::class, 'tables'])->name('tables');
    Route::post('tables/{table}/select', [WaiterController::class, 'selectTable'])->name('tables.select');
    Route::post('tables/{table}/free', [WaiterController::class, 'freeTable'])->name('tables.free');

    Route::get('orders', [WaiterController::class, 'pendingOrders'])->name('orders.index');
    Route::get('orders/{order}', [WaiterController::class, 'review'])->name('orders.show');
    Route::post('orders/{order}/confirm', [WaiterController::class, 'confirm'])->name('orders.confirm');
});

/*
|--------------------------------------------------------------------------
| Customer (tablet menu, no login - scoped by table)
|--------------------------------------------------------------------------
*/
Route::prefix('table/{table}')->name('customer.')->group(function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu');

    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/increase', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('cart', [CartController::class, 'show'])->name('cart');

    Route::get('summary', [CustomerOrderController::class, 'summary'])->name('summary');
    Route::post('order', [CustomerOrderController::class, 'store'])->name('order.store');
    Route::get('order/{order}/confirmation', [CustomerOrderController::class, 'confirmation'])->name('order.confirmation');
});
