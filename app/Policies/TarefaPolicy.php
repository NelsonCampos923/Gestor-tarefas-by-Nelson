<?php

namespace App\Policies;

use App\Models\Tarefa;
use App\Models\User;

class TarefaPolicy
{
    public function ver(User $utilizador, Tarefa $tarefa): bool
    {
        return $utilizador->id === $tarefa->user_id;
    }

    public function criar(User $utilizador): bool
    {
        return true;
    }

    public function actualizar(User $utilizador, Tarefa $tarefa): bool
    {
        return $utilizador->id === $tarefa->user_id;
    }

    public function apagar(User $utilizador, Tarefa $tarefa): bool
    {
        return $utilizador->id === $tarefa->user_id;
    }

    public function restaurar(User $utilizador, Tarefa $tarefa): bool
    {
        return $utilizador->id === $tarefa->user_id;
    }

    public function apagarDefinitivamente(User $utilizador, Tarefa $tarefa): bool
    {
        return $utilizador->id === $tarefa->user_id;
    }
}