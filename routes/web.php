<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.show_login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/alunos', function () {
    return view('alunos');
});

Route::get('/vagas', function () {
    return view('vagas');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/teste-htmx', function () {
    return '<div class="alert alert-success">O HTMX está se comunicando perfeitamente com o Laravel! O conteúdo foi carregado sem recarregar a página.</div>';
});