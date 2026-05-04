<?php

namespace App\Enums;

enum Prioridade: string
{
    case Baixa = 'baixa';
    case Media = 'media';
    case Alta  = 'alta';

    public function label(): string
    {
        return match($this) {
            Prioridade::Baixa => 'Baixa',
            Prioridade::Media => 'Média',
            Prioridade::Alta  => 'Alta',
        };
    }

    public function badge(): string
    {
        return match($this) {
            Prioridade::Baixa => 'success',
            Prioridade::Media => 'warning',
            Prioridade::Alta  => 'danger',
        };
    }
}