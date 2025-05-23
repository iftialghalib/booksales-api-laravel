<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/Author', [AuthorController::class, 'index']);
Route::post('/Author', [AuthorController::class, 'store']);
Route::get('/Author/{id}', [AuthorController::class, 'show']);
Route::post('/Author/{id}', [AuthorController::class, 'update']);
Route::delete('/Author/{id}', [AuthorController::class, 'destroy']);



Route::get('/Genre', [GenreController::class, 'index']);
Route::post('/Genre', [GenreController::class, 'store']);
Route::get('/Genre/{id}', [GenreController::class, 'show']);
Route::post('/Genre/{id}', [GenreController::class, 'update']);
Route::delete('/Genre/{id}', [GenreController::class, 'destroy']);



Route::get('/Book', [BookController::class, 'index']);
Route::post('/Book', [BookController::class, 'store']);
Route::get('/Book/{id}', [BookController::class, 'show']);
Route::post('/Book/{id}', [BookController::class, 'update']);
Route::delete('/Book/{id}', [BookController::class, 'destroy']);


