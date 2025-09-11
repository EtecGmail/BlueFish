<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');

Route::view('/contato', 'contato.index')->name('contato.form');
Route::post('/contato', [ContatoController::class, 'store'])->name('contato.store');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::view('/registro', 'auth.register')->name('register.form');
    Route::post('/registro', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto.show');
});
