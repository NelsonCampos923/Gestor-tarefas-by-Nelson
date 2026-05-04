<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Enums\Status;
use App\Enums\Prioridade;
use App\Http\Requests\ArmazenarTarefaRequest;
use App\Http\Requests\ActualizarTarefaRequest;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    // ─── LISTA DE TAREFAS ───────────────────────────
    public function index(Request $request)
    {
        $query = auth()->user()->tarefas()->latest();

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por prioridade
        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        // Pesquisa por título
        if ($request->filled('pesquisa')) {
            $query->where('titulo', 'like', '%' . $request->pesquisa . '%');
        }

        $tarefas = $query->paginate(10);

        // Estatísticas para o dashboard
        $estatisticas = [
            'total'     => auth()->user()->tarefas()->count(),
            'pendente'  => auth()->user()->tarefas()->pendente()->count(),
            'progresso' => auth()->user()->tarefas()->progresso()->count(),
            'concluida' => auth()->user()->tarefas()->concluida()->count(),
            'atrasada'  => auth()->user()->tarefas()->atrasada()->count(),
        ];

        return view('tarefas.index', compact('tarefas', 'estatisticas'));
    }

    // ─── FORMULÁRIO CRIAR ───────────────────────────
    public function create()
    {
        $status     = Status::cases();
        $prioridade = Prioridade::cases();
        return view('tarefas.criar', compact('status', 'prioridade'));
    }

    // ─── GUARDAR NOVA TAREFA ────────────────────────
    public function store(ArmazenarTarefaRequest $request)
    {
        auth()->user()->tarefas()->create($request->validated());

        return redirect()
            ->route('tarefas.index')
            ->with('sucesso', 'Tarefa criada com sucesso!');
    }

    // ─── VER TAREFA ─────────────────────────────────
    public function show(Tarefa $tarefa)
    {
        $this->authorize('ver', $tarefa);
        return view('tarefas.ver', compact('tarefa'));
    }

    // ─── FORMULÁRIO EDITAR ──────────────────────────
    public function edit(Tarefa $tarefa)
    {
        $this->authorize('actualizar', $tarefa);
        $status     = Status::cases();
        $prioridade = Prioridade::cases();
        return view('tarefas.editar', compact('tarefa', 'status', 'prioridade'));
    }

    // ─── ACTUALIZAR TAREFA ──────────────────────────
    public function update(ActualizarTarefaRequest $request, Tarefa $tarefa)
    {
        $this->authorize('actualizar', $tarefa);
        $tarefa->update($request->validated());

        return redirect()
            ->route('tarefas.index')
            ->with('sucesso', 'Tarefa actualizada com sucesso!');
    }

    // ─── SOFT DELETE ────────────────────────────────
    public function destroy(Tarefa $tarefa)
    {
        $this->authorize('apagar', $tarefa);
        $tarefa->delete();

        return redirect()
            ->route('tarefas.index')
            ->with('sucesso', 'Tarefa movida para a lixeira!');
    }

    // ─── LIXEIRA ────────────────────────────────────
    public function lixeira()
    {
        $tarefas = auth()->user()
                         ->tarefas()
                         ->onlyTrashed()
                         ->latest('deleted_at')
                         ->paginate(10);

        return view('tarefas.lixeira', compact('tarefas'));
    }

    // ─── RESTAURAR ──────────────────────────────────
    public function restaurar($id)
    {
        $tarefa = Tarefa::onlyTrashed()->findOrFail($id);
        $this->authorize('restaurar', $tarefa);
        $tarefa->restore();

        return redirect()
            ->route('tarefas.lixeira')
            ->with('sucesso', 'Tarefa restaurada com sucesso!');
    }

    // ─── APAGAR DEFINITIVAMENTE ─────────────────────
    public function apagarDefinitivamente($id)
    {
        $tarefa = Tarefa::onlyTrashed()->findOrFail($id);
        $this->authorize('apagarDefinitivamente', $tarefa);
        $tarefa->forceDelete();

        return redirect()
            ->route('tarefas.lixeira')
            ->with('sucesso', 'Tarefa eliminada definitivamente!');
    }
}