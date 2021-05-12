<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SubscriptorsController;
use App\Http\Controllers\UsersController;

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

Route::name('job_posts.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/job_posts', [JobPostsController::class, 'index'])->name('index');

    Route::post('/job_posts', [JobPostsController::class, 'store'])->name('store');

    Route::put('/job_posts/{job_posts}', [JobPostsController::class, 'update'])->name('update');

    Route::delete('/job_posts/{job_posts}', [JobPostsController::class, 'destroy'])->name('destroy');
});

Route::name('orders.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('index');

    Route::post('/orders', [OrdersController::class, 'store'])->name('store');

    Route::put('/orders/{orders}', [OrdersController::class, 'update'])->name('update');

    Route::delete('/orders/{orders}', [OrdersController::class, 'destroy'])->name('destroy');
});

Route::name('subscriptors.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/subscriptors', [SubscriptorsController::class, 'index'])->name('index');

    Route::post('/subscriptors', [SubscriptorsController::class, 'store'])->name('store');

    Route::put('/subscriptors/{subscriptors}', [SubscriptorsController::class, 'update'])->name('update');

    Route::delete('/subscriptors/{subscriptors}', [SubscriptorsController::class, 'destroy'])->name('destroy');
});

Route::name('users.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('index');

    Route::post('/users', [UsersController::class, 'store'])->name('store');

    Route::put('/users/{users}', [UsersController::class, 'update'])->name('update');

    Route::delete('/users/{users}', [UsersController::class, 'destroy'])->name('destroy');
});
