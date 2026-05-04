<?php

namespace App\Enums;

enum Status: string
{
    case Pendente  = 'pendente';
    case Progresso = 'progresso';
    case Concluida = 'concluida';

    public function label(): string
    {
        return match($this) {
            Status::Pendente  => 'Pendente',
            Status::Progresso => 'Em Progresso',
            Status::Concluida => 'Concluída',
        };
    }

    public function badge(): string
    {
        return match($this) {
            Status::Pendente  => 'warning',
            Status::Progresso => 'primary',
            Status::Concluida => 'success',
        };
    }
}