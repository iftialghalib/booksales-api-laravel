<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Author', [AuthorController::class, 'index']);

Route::get('/Genre', [GenreController::class, 'index']);

Route::get('/Book', [BookController::class, 'index']);
