<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // ── Utilizadores com contagens ──────────────────────────
        $utilizadores = User::withCount([
            'tarefas',
            'tarefas as pendentes_count'  => fn($q) => $q->where('status', 'pendente'),
            'tarefas as concluidas_count' => fn($q) => $q->where('status', 'concluida'),
        ])->latest()->get();

        // ── Ranking: ordena por (tarefas criadas + concluídas*2) ─
        $ranking = User::withCount([
            'tarefas',
            'tarefas as concluidas_count' => fn($q) => $q->where('status', 'concluida'),
        ])
        ->get()
        ->sortByDesc(fn($u) => $u->tarefas_count + ($u->concluidas_count * 2))
        ->take(10)
        ->values();

        // ── Utilizador com mais tarefas criadas ─────────────────
        $topCriador = User::withCount('tarefas')
            ->orderByDesc('tarefas_count')
            ->first();

        // ── Utilizador com mais tarefas concluídas ──────────────
        $topConcluidor = User::withCount([
            'tarefas as concluidas_count' => fn($q) => $q->where('status', 'concluida'),
        ])
        ->orderByDesc('concluidas_count')
        ->first();

        // ── Activos hoje: criaram tarefas nas últimas 24h ────────
        $activosHoje = User::whereHas('tarefas', function ($q) {
            $q->where('created_at', '>=', now()->subDay());
        })->count();

        // ── Stats gerais ─────────────────────────────────────────
        $stats = [
            'total_users'          => User::count(),
            'total_admins'         => User::where('role', 'admin')->count(),
            'activos_hoje'         => $activosHoje,
            'top_criador'          => $topCriador?->name,
            'top_criador_count'    => $topCriador?->tarefas_count ?? 0,
            'top_concluidor'       => $topConcluidor?->name,
            'top_concluidor_count' => $topConcluidor?->concluidas_count ?? 0,
        ];

        return view('admin.index', compact('stats', 'utilizadores', 'ranking'));
    }

    // ── Apagar utilizador ────────────────────────────────────────
    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('erro', 'Não podes apagar um administrador.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('erro', 'Não podes apagar a tua própria conta aqui.');
        }

        $user->tarefas()->forceDelete();
        $user->delete();

        return back()->with('sucesso', 'Utilizador eliminado com sucesso!');
    }

    // ── Promover / rebaixar role ─────────────────────────────────
    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('erro', 'Não podes alterar o teu próprio role.');
        }

        $user->role = $user->isAdmin() ? 'user' : 'admin';
        $user->save();

        $novoRole = $user->role === 'admin' ? 'Administrador' : 'Utilizador';

        return back()->with('sucesso', "{$user->name} é agora {$novoRole}.");
    }
}