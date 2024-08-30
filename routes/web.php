<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware('admin')->group(function(){
    Route::get('/create', [ItemController::class, 'getCreatePage'])->name('getCreatePage');
    Route::post('/create-item', [ItemController::class, 'createItem'])->name('createItem');
    Route::post('/create-category', [ItemController::class, 'createCategory'])->name('createCategory');
    Route::get('/update/{id}', [ItemController::class, 'getItemById'])->name('getItemById');
    Route::patch('/update/{id}', [ItemController::class, 'updateItem'])->name('updateItem');
    Route::delete('/delete-item/{id}', [ItemController::class, 'deleteItem'])->name('deleteItem');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //View Item
    Route::get('/get-items', [ItemController::class, 'getItems'])->name('getItems');
    Route::get('/view', [ItemController::class, 'getItems'])->name('getItems');
    Route::get('/view/search', [ItemController::class, 'searchItems'])->name('searchItems');

    //Cart
    Route::get('/cart', [CartController::class, 'getCart'])->name('getCart');
    Route::post('/cartStore', [CartController::class, 'cartStore'])->name('cartStore');
    Route::get('/cart/search', [CartController::class, 'searchCarts'])->name('searchCarts');
    Route::delete('/deleteCart/{id}', [CartController::class, 'deleteCart'])->name('deleteCart');

    //Invoice
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('storeInvoice');
    Route::get('/invoices', [InvoiceController::class, 'listInvoice'])->name('listInvoice');
    Route::get('/invoice/{id}', [InvoiceController::class, 'getInvoice'])->name('getInvoice');
    Route::get('/invoice/{id}/export', [InvoiceController::class, 'exportPDF'])->name('exportPDF');
});

require __DIR__.'/auth.php';
