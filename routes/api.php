<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get_invoices', [\App\Http\Controllers\InvoiceController::class, 'getInvoices']);

Route::get('/search_invoice', [\App\Http\Controllers\InvoiceController::class, 'searchInvoice']);

Route::get('/create_invoice', [\App\Http\Controllers\InvoiceController::class, 'create']);

Route::post('/add_invoice', [\App\Http\Controllers\InvoiceController::class, 'store']);

Route::get('/invoice/show/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'show']);

Route::get('/invoice/delete/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'destroy']);

Route::post('/invoice/update/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'update']);

Route::get('/invoice/delete/item/{invoiceItem}', [\App\Http\Controllers\InvoiceController::class, 'deleteItem']);

Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index']);

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']);





