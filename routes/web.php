<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\WaiterController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Waiter\AuthController as WaiterAuthController;
use App\Http\Controllers\Waiter\WaiterController as WaiterDashController;

Route::get('/', function () {
    return redirect()->route('waiter.login');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest-only routes
    Route::middleware('guest')->group(function () {
        Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    });

    // Admin-authenticated routes
    Route::middleware('auth.admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products',   ProductController::class);
        Route::resource('tables',     TableController::class);

        Route::resource('orders', AdminOrderController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        // Waiter management
        Route::get   ('waiters',         [WaiterController::class, 'index'])->name('waiters.index');
        Route::get   ('waiters/create',  [WaiterController::class, 'create'])->name('waiters.create');
        Route::post  ('waiters',         [WaiterController::class, 'store'])->name('waiters.store');
        Route::delete('waiters/{waiter}',[WaiterController::class, 'destroy'])->name('waiters.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Waiter
|--------------------------------------------------------------------------
*/
Route::prefix('waiter')->name('waiter.')->group(function () {
    // Guest-only routes
    Route::middleware('guest')->group(function () {
        Route::get('login',  [WaiterAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [WaiterAuthController::class, 'login'])->name('login.attempt');
    });

    // Waiter-authenticated routes
    Route::middleware('auth.waiter')->group(function () {
        Route::post('logout', [WaiterAuthController::class, 'logout'])->name('logout');

        Route::get('/',                              [WaiterDashController::class, 'tables'])->name('tables');
        Route::post('tables/{table}/select',         [WaiterDashController::class, 'selectTable'])->name('tables.select');
        Route::post('tables/{table}/free',           [WaiterDashController::class, 'freeTable'])->name('tables.free');

        Route::get ('orders',                        [WaiterDashController::class, 'pendingOrders'])->name('orders.index');
        Route::get ('orders/{order}',                [WaiterDashController::class, 'review'])->name('orders.show');
        Route::post('orders/{order}/confirm',        [WaiterDashController::class, 'confirm'])->name('orders.confirm');
    });
});

/*
|--------------------------------------------------------------------------
| Customer (tablet menu, no login – scoped by table)
|--------------------------------------------------------------------------
*/
Route::prefix('table/{table}')->name('customer.')->group(function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu');

    Route::post('cart/add',      [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/increase', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('cart/remove',   [CartController::class, 'remove'])->name('cart.remove');
    Route::get ('cart',          [CartController::class, 'show'])->name('cart');

    Route::get ('summary',                        [CustomerOrderController::class, 'summary'])->name('summary');
    Route::post('order',                          [CustomerOrderController::class, 'store'])->name('order.store');
    Route::get ('order/{order}/confirmation',     [CustomerOrderController::class, 'confirmation'])->name('order.confirmation');
});
