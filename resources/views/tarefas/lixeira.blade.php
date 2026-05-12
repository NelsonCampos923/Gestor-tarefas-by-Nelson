@extends('layouts.app')

@section('titulo', 'Lixeira')

@section('topbar-acoes')
    <a href="{{ route('tarefas.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Voltar
    </a>
@endsection

@section('conteudo')

    @if(session('sucesso'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
            <div class="toast show align-items-center text-bg-success border-0 shadow">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('sucesso') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if($tarefas->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-trash-alt fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">A lixeira está vazia.</p>
                    <a href="{{ route('tarefas.index') }}" class="btn btn-primary btn-sm mt-3">
                        <i class="fas fa-arrow-left me-1"></i> Voltar às Tarefas
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Apagada em</th>
                                <th class="text-end pe-4">Acções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarefas as $tarefa)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold text-muted text-decoration-line-through">
                                            {{ $tarefa->titulo }}
                                        </div>
                                        @if($tarefa->descricao)
                                            <div class="small text-muted text-truncate" style="max-width:250px">
                                                {{ $tarefa->descricao }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $tarefa->prioridade->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $tarefa->status->label() }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $tarefa->deleted_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <form method="POST" action="{{ route('tarefas.restaurar', $tarefa->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-undo me-1"></i> Restaurar
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                data-id="{{ $tarefa->id }}"
                                                data-titulo="{{ $tarefa->titulo }}">
                                            <i class="fas fa-times me-1"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($tarefas->hasPages())
                    <div class="d-flex justify-content-center py-3">
                        {{ $tarefas->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- MODAL ELIMINAR --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i> Atenção!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="text-muted small mb-1">Eliminar definitivamente:</p>
                    <p class="fw-bold text-danger mb-1" id="eliminar-titulo">—</p>
                    <p class="small text-muted mb-0">Esta acção não pode ser revertida.</p>
                </div>
                <div class="modal-footer justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" id="formEliminar" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('modalEliminar').addEventListener('show.bs.modal', e => {
        const b = e.relatedTarget;
        document.getElementById('eliminar-titulo').textContent = b.dataset.titulo;
        document.getElementById('formEliminar').action = `/tarefas/${b.dataset.id}/eliminar`;
    });

    setTimeout(() => {
        const t = document.querySelector('.toast');
        if (t) new bootstrap.Toast(t, { delay: 3000 }).show();
    }, 100);
</script>
@endpush