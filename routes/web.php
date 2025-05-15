<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/raw-materials', [RawMaterialController::class, 'index'])->name('raw_materials');
Route::get('/raw-materials/create', [RawMaterialController::class, 'create'])->name('raw_materials.create');
Route::post('/raw-materials', [RawMaterialController::class, 'store'])->name('raw_materials.store');
Route::get('/raw-materials/{id}/edit', [RawMaterialController::class, 'edit'])->name('raw_materials.edit');
Route::put('/raw-materials/{id}', [RawMaterialController::class, 'update'])->name('raw_materials.update');
Route::get('/raw-materials/{id}', [RawMaterialController::class, 'show'])->name('raw_materials.show');
Route::get('/raw-materials/{id}/delete', [RawMaterialController::class, 'destroy'])->name('raw_materials.delete');


Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('/suppliers/{id}/delete', [SupplierController::class, 'destroy'])->name('suppliers.delete');


Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');
Route::get('/products/{id}/raw-materials', [ProductController::class, 'showRawMaterials'])->name('products.raw_materials');

Route::get('/bill-of-materials', [BillOfMaterialController::class, 'index'])->name('bill_of_materials');
Route::get('/bill-of-materials/create', [BillOfMaterialController::class, 'create'])->name('bill_of_materials.create');
Route::post('/bill-of-materials', [BillOfMaterialController::class, 'store'])->name('bill_of_materials.store');
Route::get('/bill-of-materials/{id}/edit', [BillOfMaterialController::class, 'edit'])->name('bill_of_materials.edit');
Route::put('/bill-of-materials/{id}', [BillOfMaterialController::class, 'update'])->name('bill_of_materials.update');
Route::get('/bill-of-materials/{id}', [BillOfMaterialController::class, 'show'])->name('bill_of_materials.show');

// Route::get('/', function () {
//     return view('welcome');
// });