@extends('layouts.app')

@section('titulo', 'Painel Admin')

@section('conteudo')

{{-- Alertas --}}
@if(session('sucesso'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4 rounded-3 py-2 px-3"
         style="font-size:.85rem;border:1px solid #bbf7d0;background:#f0fdf4;color:#166534;">
        <i class="fas fa-check-circle"></i> {{ session('sucesso') }}
    </div>
@endif
@if(session('erro'))
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 rounded-3 py-2 px-3"
         style="font-size:.85rem;border:1px solid #fecaca;background:#fef2f2;color:#991b1b;">
        <i class="fas fa-exclamation-circle"></i> {{ session('erro') }}
    </div>
@endif

{{-- ── CARDS DE ESTATÍSTICAS ─────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Total utilizadores --}}
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;color:#4f46e5;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-valor">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Utilizadores</div>
            <div class="stat-sub">
                <span style="color:#4f46e5;">{{ $stats['total_admins'] }} admin</span>
                · {{ $stats['total_users'] - $stats['total_admins'] }} normais
            </div>
        </div>
    </div>

    {{-- Activos hoje --}}
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;color:#16a34a;">
                <i class="fas fa-circle" style="font-size:.5rem;vertical-align:middle;"></i>
                <i class="fas fa-user ms-1"></i>
            </div>
            <div class="stat-valor">{{ $stats['activos_hoje'] }}</div>
            <div class="stat-label">Activos Hoje</div>
            <div class="stat-sub">criaram tarefas nas últimas 24h</div>
        </div>
    </div>

    {{-- Melhor criador --}}
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;color:#d97706;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-valor" style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:.25rem;">
                {{ $stats['top_criador'] ?? '—' }}
            </div>
            <div class="stat-label">Mais Tarefas Criadas</div>
            <div class="stat-sub">{{ $stats['top_criador_count'] ?? 0 }} tarefas</div>
        </div>
    </div>

    {{-- Melhor concluidor --}}
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdfa;color:#0d9488;">
                <i class="fas fa-medal"></i>
            </div>
            <div class="stat-valor" style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:.25rem;">
                {{ $stats['top_concluidor'] ?? '—' }}
            </div>
            <div class="stat-label">Mais Tarefas Concluídas</div>
            <div class="stat-sub">{{ $stats['top_concluidor_count'] ?? 0 }} concluídas</div>
        </div>
    </div>

</div>

{{-- ── RANKING + TABELA ──────────────────────────────────── --}}
<div class="row g-3">

    {{-- RANKING --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                <i class="fas fa-ranking-star" style="color:#d97706;"></i>
                <span class="fw-bold" style="font-size:.875rem;">Ranking de Utilizadores</span>
            </div>
            <div class="card-body p-0">
                @foreach($ranking as $index => $user)
                    <div class="ranking-row {{ $index === 0 ? 'ranking-top' : '' }}">

                        {{-- Posição --}}
                        <div class="ranking-pos">
                            @if($index === 0)
                                <i class="fas fa-trophy" style="color:#d97706;font-size:.9rem;"></i>
                            @elseif($index === 1)
                                <i class="fas fa-medal" style="color:#94a3b8;font-size:.9rem;"></i>
                            @elseif($index === 2)
                                <i class="fas fa-medal" style="color:#b45309;font-size:.9rem;"></i>
                            @else
                                <span style="font-size:.75rem;color:#94a3b8;font-weight:600;">{{ $index + 1 }}</span>
                            @endif
                        </div>

                        {{-- Avatar + nome --}}
                        <div class="ranking-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="ranking-nome">{{ $user->name }}</div>
                            <div class="ranking-sub">
                                {{ $user->tarefas_count }} criadas ·
                                {{ $user->concluidas_count }} concluídas
                            </div>
                            {{-- Barra de progresso --}}
                            @if($user->tarefas_count > 0)
                                @php $pct = round(($user->concluidas_count / $user->tarefas_count) * 100) @endphp
                                <div class="ranking-bar-bg mt-1">
                                    <div class="ranking-bar-fill" style="width:{{ $pct }}%;"></div>
                                </div>
                            @endif
                        </div>

                        {{-- Score --}}
                        <div class="ranking-score">
                            {{ $user->tarefas_count + ($user->concluidas_count * 2) }}
                            <span style="font-size:.6rem;color:#94a3b8;display:block;text-align:center;">pts</span>
                        </div>

                    </div>
                @endforeach

                @if($ranking->isEmpty())
                    <div class="text-center py-4 text-muted" style="font-size:.8rem;">
                        Sem dados de ranking ainda.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TABELA DE UTILIZADORES --}}
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-users" style="color:var(--cor-primaria);"></i>
                    <span class="fw-bold" style="font-size:.875rem;">Utilizadores Registados</span>
                </div>
                <span class="badge bg-light text-muted border" style="font-size:.7rem;">
                    {{ $utilizadores->count() }} total
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Utilizador</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Pendentes</th>
                                <th class="text-center">Concluídas</th>
                                <th class="text-center">Acções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($utilizadores as $user)
                            <tr>
                                {{-- Info utilizador --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mini-avatar" style="background:{{ $user->isAdmin() ? '#d97706' : 'var(--cor-primaria)' }};">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-size:.825rem;font-weight:600;color:#1e293b;">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="badge bg-light text-muted border ms-1" style="font-size:.6rem;">Tu</span>
                                                @endif
                                            </div>
                                            <div style="font-size:.7rem;color:#94a3b8;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role --}}
                                <td class="text-center">
                                    @if($user->isAdmin())
                                        <span class="badge" style="background:rgba(217,119,6,.12);color:#d97706;border:1px solid rgba(217,119,6,.25);">
                                            <i class="fas fa-shield-alt me-1"></i>Admin
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border">
                                            <i class="fas fa-user me-1"></i>User
                                        </span>
                                    @endif
                                </td>

                                {{-- Contagens --}}
                                <td class="text-center">
                                    <span class="fw-bold" style="color:var(--cor-primaria);">{{ $user->tarefas_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-warning">{{ $user->pendentes_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-success">{{ $user->concluidas_count }}</span>
                                </td>

                                {{-- Acções --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- Toggle role --}}
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-secondary"
                                                        style="font-size:.7rem;padding:.25rem .5rem;"
                                                        title="{{ $user->isAdmin() ? 'Tornar User' : 'Tornar Admin' }}">
                                                    <i class="fas fa-user-shield"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Apagar --}}
                                        @if(!$user->isAdmin() && $user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Apagar {{ $user->name }} e todas as suas tarefas?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                        style="font-size:.7rem;padding:.25rem .5rem;"
                                                        title="Eliminar utilizador">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('estilos')
<style>
    /* ── STAT CARDS ───────────────────── */
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        padding: 1.25rem;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,.07);
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: .5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .875rem;
        margin-bottom: .75rem;
    }

    .stat-valor {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }

    .stat-label {
        font-size: .75rem;
        font-weight: 600;
        color: #475569;
        margin-top: .2rem;
    }

    .stat-sub {
        font-size: .7rem;
        color: #94a3b8;
        margin-top: .2rem;
    }

    /* ── RANKING ──────────────────────── */
    .ranking-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }

    .ranking-row:last-child { border-bottom: none; }
    .ranking-row:hover { background: #f8fafc; }

    .ranking-top {
        background: linear-gradient(90deg, #fffbeb, #fff);
    }

    .ranking-pos {
        width: 22px;
        text-align: center;
        flex-shrink: 0;
    }

    .ranking-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--cor-primaria);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .ranking-nome {
        font-size: .8rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ranking-sub {
        font-size: .67rem;
        color: #94a3b8;
    }

    .ranking-bar-bg {
        height: 3px;
        background: #e2e8f0;
        border-radius: 2px;
        width: 100%;
    }

    .ranking-bar-fill {
        height: 3px;
        background: #22c55e;
        border-radius: 2px;
        transition: width .5s ease;
    }

    .ranking-score {
        font-size: .85rem;
        font-weight: 700;
        color: #4f46e5;
        flex-shrink: 0;
        min-width: 30px;
        text-align: center;
    }

    /* ── MINI AVATAR TABELA ───────────── */
    .mini-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* ── TABELA ───────────────────────── */
    .table thead th {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #94a3b8;
        padding: .75rem 1rem;
    }

    .table tbody td {
        padding: .75rem 1rem;
        vertical-align: middle;
    }
</style>
@endpush