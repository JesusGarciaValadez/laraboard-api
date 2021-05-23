<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceStatusController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('country.index')->get('/country', CountryController::class);
Route::name('role.index')->get('/role', RoleController::class);
Route::name('invoice_status.index')->get('/invoice_status', InvoiceStatusController::class);
Route::name('order_status.index')->get('/order_status', OrderStatusController::class);

Route::middleware(['auth:sanctum'])->group(fn () => Route::resource('/user', UserController::class));
Route::middleware(['auth:sanctum'])->group(fn () => Route::resource('/discount', DiscountController::class));
Route::middleware(['auth:sanctum'])->group(fn () => Route::resource('/job_post', JobPostController::class));
Route::middleware(['auth:sanctum'])->group(fn () => Route::resource('/order', OrderController::class));
Route::middleware(['auth:sanctum'])->group(fn () => Route::resource('/invoice', InvoiceController::class));
