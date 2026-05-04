<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

// Página inicial → redireciona para login
Route::get('/', fn() => redirect()->route('login'));

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard → redireciona para lista de tarefas
    Route::get('/dashboard', fn() => redirect()->route('tarefas.index'))
         ->name('dashboard');

    // Lixeira (antes do resource para não conflituar)
    Route::get('/tarefas/lixeira', [TarefaController::class, 'lixeira'])
         ->name('tarefas.lixeira');

    Route::patch('/tarefas/{id}/restaurar', [TarefaController::class, 'restaurar'])
         ->name('tarefas.restaurar');

    Route::delete('/tarefas/{id}/eliminar', [TarefaController::class, 'apagarDefinitivamente'])
         ->name('tarefas.eliminar');

    // CRUD principal
    Route::resource('tarefas', TarefaController::class);
});