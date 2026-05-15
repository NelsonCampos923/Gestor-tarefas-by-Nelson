<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PerfilController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.index');
        }
        return redirect()->route('tarefas.index');
    })->name('dashboard');

    Route::get('/tarefas/lixeira', [TarefaController::class, 'lixeira'])->name('tarefas.lixeira');
    Route::patch('/tarefas/{id}/restaurar', [TarefaController::class, 'restaurar'])->name('tarefas.restaurar');
    Route::delete('/tarefas/{id}/eliminar', [TarefaController::class, 'apagarDefinitivamente'])->name('tarefas.eliminar');
    Route::resource('tarefas', TarefaController::class);
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('perfil.eliminar');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::delete('/utilizadores/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/utilizadores/{user}/role', [AdminController::class, 'toggleRole'])->name('users.role');
});
