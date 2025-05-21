<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BillOfMaterialController;

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::get('/transactions/cashier', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('/transactions/history', [TransactionController::class, 'historyIndex'])->name('transactions.history');

Route::get('/raw-materials', [RawMaterialController::class, 'index'])->name('raw_materials');
Route::get('/raw-materials/create', [RawMaterialController::class, 'create'])->name('raw_materials.create');
Route::post('/raw-materials', [RawMaterialController::class, 'store'])->name('raw_materials.store');
Route::get('/raw-materials/{slug}/edit', [RawMaterialController::class, 'edit'])->name('raw_materials.edit');
Route::put('/raw-materials/{slug}', [RawMaterialController::class, 'update'])->name('raw_materials.update');
Route::get('/raw-materials/{slug}', [RawMaterialController::class, 'show'])->name('raw_materials.show');
Route::get('/raw-materials/{slug}/delete', [RawMaterialController::class, 'destroy'])->name('raw_materials.delete');


Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/{slug}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('/suppliers/{slug}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::get('/suppliers/{slug}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('/suppliers/{slug}/delete', [SupplierController::class, 'destroy'])->name('suppliers.delete');


Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{slug}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{slug}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{slug}/delete', [ProductController::class, 'destroy'])->name('products.delete');
Route::get('/products/{slug}/raw-materials', [ProductController::class, 'showRawMaterials'])->name('products.raw_materials');

Route::get('/bill-of-materials', [BillOfMaterialController::class, 'index'])->name('bill_of_materials');
Route::get('/bill-of-materials/create', [BillOfMaterialController::class, 'create'])->name('bill_of_materials.create');
Route::post('/bill-of-materials', [BillOfMaterialController::class, 'store'])->name('bill_of_materials.store');
Route::get('/bill-of-materials/{slug}/edit', [BillOfMaterialController::class, 'edit'])->name('bill_of_materials.edit');
Route::put('/bill-of-materials/{slug}', [BillOfMaterialController::class, 'update'])->name('bill_of_materials.update');
Route::get('/bill-of-materials/{slug}', [BillOfMaterialController::class, 'show'])->name('bill_of_materials.show');
Route::get('/bill-of-materials/{slug}/delete', [BillOfMaterialController::class, 'destroy'])->name('bill_of_materials.delete');



// Route::get('/', function () {
//     return view('welcome');
// });