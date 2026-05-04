<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\Prioridade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarefa extends Model
{
    use HasFactory, SoftDeletes;

    // Nome da tabela em português
    protected $table = 'tarefas';

    // Campos preenchíveis
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'prioridade',
        'status',
        'prazo',
    ];

    // Conversão automática de tipos
    protected $casts = [
        'status'     => Status::class,
        'prioridade' => Prioridade::class,
        'prazo'      => 'date',
    ];

    // ─── RELAÇÃO ────────────────────────────────────
    public function utilizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── SCOPES ─────────────────────────────────────
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeProgresso($query)
    {
        return $query->where('status', 'progresso');
    }

    public function scopeConcluida($query)
    {
        return $query->where('status', 'concluida');
    }

    public function scopeAtrasada($query)
    {
        return $query->where('prazo', '<', now())
                     ->where('status', '!=', 'concluida');
    }

    public function scopeAltaPrioridade($query)
    {
        return $query->where('prioridade', 'alta');
    }

    // ─── ACCESSOR ───────────────────────────────────
    public function getAtrasadaAttribute(): bool
    {
        return $this->prazo &&
               $this->prazo->isPast() &&
               $this->status !== Status::Concluida;
    }
}