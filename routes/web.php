<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Login admin separado (view)
    Route::view('/admin/login', 'auth.admin-login')->name('admin.login.form');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');

    Route::view('/registro', 'auth.register')->name('register.form');
    Route::post('/registro', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto.show');
    Route::get('/vendas', [VendaController::class, 'index'])->name('vendas.index');
    Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
    Route::view('/contato', 'contato.index')->name('contato.form');
    Route::post('/contato', [ContatoController::class, 'store'])->name('contato.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin
    Route::view('/admin', 'admin.index')->name('admin.index');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
