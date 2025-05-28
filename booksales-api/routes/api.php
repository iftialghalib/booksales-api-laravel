<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/Register', [AuthController::class, 'register']);
Route::post('/Login', [AuthController::class, 'login']);
Route::post('/Logout', [AuthController::class, 'Logout'])->middleware('auth:api');

// Route::middleware(['auth:api', 'role:admin'])->get('/admin-test', function () {
//     return response()->json(['message' => 'Hello, Admin!']);
// });

Route::apiResource('/Book', BookController::class)->only('index', 'show');
Route::apiResource('/Genre', GenreController::class)->only('index', 'show');
Route::apiResource('/Author', AuthorController::class)->only('index', 'show');


Route::middleware(['auth:api'])->group(function () {

    Route::apiResource('/transaction', TransactionController::class)->only('store', 'update', 'show');

    Route::middleware(['role:admin'])->group(function () {

        Route::apiResource('/transaction', TransactionController::class)->only('index', 'destroy');
        Route::apiResource('/Book', BookController::class)->only('store', 'update', 'destroy');
        Route::apiResource('/Genre', GenreController::class)->only('store', 'update', 'destroy');
        Route::apiResource('/Author', AuthorController::class)->only('store', 'update', 'destroy');
    });
});
