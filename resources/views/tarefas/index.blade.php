@extends('layouts.app')

@section('titulo', 'Minhas Tarefas')

@section('topbar-acoes')
    <a href="{{ route('tarefas.lixeira') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-trash-alt me-1"></i> Lixeira
    </a>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCriar">
        <i class="fas fa-plus me-1"></i> Nova Tarefa
    </button>
@endsection

@section('conteudo')

    {{-- TOAST --}}
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

    {{-- ESTATÍSTICAS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card-stat">
                <div class="stat-valor text-dark">{{ $estatisticas['total'] }}</div>
                <div class="stat-label"><i class="fas fa-clipboard-list me-1"></i> Total</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card-stat" style="border-left: 4px solid #f59e0b;">
                <div class="stat-valor text-warning">{{ $estatisticas['pendente'] }}</div>
                <div class="stat-label"><i class="fas fa-clock me-1"></i> Pendentes</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card-stat" style="border-left: 4px solid #4f46e5;">
                <div class="stat-valor" style="color:var(--cor-primaria)">{{ $estatisticas['progresso'] }}</div>
                <div class="stat-label"><i class="fas fa-spinner me-1"></i> Em Progresso</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card-stat" style="border-left: 4px solid #10b981;">
                <div class="stat-valor text-success">{{ $estatisticas['concluida'] }}</div>
                <div class="stat-label"><i class="fas fa-check-circle me-1"></i> Concluídas</div>
            </div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tarefas.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Pesquisar</label>
                    <input type="text" name="pesquisa" class="form-control form-control-sm"
                           placeholder="Título da tarefa..." value="{{ request('pesquisa') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="pendente"  {{ request('status') == 'pendente'  ? 'selected' : '' }}>Pendente</option>
                        <option value="progresso" {{ request('status') == 'progresso' ? 'selected' : '' }}>Em Progresso</option>
                        <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Prioridade</label>
                    <select name="prioridade" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        <option value="baixa" {{ request('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ request('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta"  {{ request('prioridade') == 'alta'  ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('tarefas.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABELA --}}
    <div class="card">
        <div class="card-body p-0">
            @if($tarefas->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">Nenhuma tarefa encontrada.</p>
                    <button class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#modalCriar">
                        <i class="fas fa-plus me-1"></i> Criar primeira tarefa
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Prazo</th>
                                <th class="text-end pe-4">Acções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarefas as $tarefa)
                                <tr class="{{ $tarefa->atrasada ? 'table-danger' : '' }}">
                                    <td class="ps-4">
                                        <div class="fw-semibold">{{ $tarefa->titulo }}</div>
                                        @if($tarefa->descricao)
                                            <div class="text-muted small text-truncate" style="max-width:250px">
                                                {{ $tarefa->descricao }}
                                            </div>
                                        @endif
                                        @if($tarefa->atrasada)
                                            <span class="badge bg-danger bg-opacity-10 text-danger mt-1">
                                                <i class="fas fa-clock me-1"></i> Atrasada
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $tarefa->prioridade->badge() }}-subtle text-{{ $tarefa->prioridade->badge() }} border border-{{ $tarefa->prioridade->badge() }}-subtle">
                                            {{ $tarefa->prioridade->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $tarefa->status->badge() }}-subtle text-{{ $tarefa->status->badge() }} border border-{{ $tarefa->status->badge() }}-subtle">
                                            {{ $tarefa->status->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($tarefa->prazo)
                                            <span class="small {{ $tarefa->atrasada ? 'text-danger fw-semibold' : 'text-muted' }}">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $tarefa->prazo->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#modalVer"
                                                data-titulo="{{ $tarefa->titulo }}"
                                                data-descricao="{{ $tarefa->descricao ?? '—' }}"
                                                data-prioridade="{{ $tarefa->prioridade->label() }}"
                                                data-status="{{ $tarefa->status->label() }}"
                                                data-prazo="{{ $tarefa->prazo ? $tarefa->prazo->format('d/m/Y') : '—' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                data-id="{{ $tarefa->id }}"
                                                data-titulo="{{ $tarefa->titulo }}"
                                                data-descricao="{{ $tarefa->descricao }}"
                                                data-prioridade="{{ $tarefa->prioridade->value }}"
                                                data-status="{{ $tarefa->status->value }}"
                                                data-prazo="{{ $tarefa->prazo ? $tarefa->prazo->format('Y-m-d') : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#modalApagar"
                                                data-id="{{ $tarefa->id }}"
                                                data-titulo="{{ $tarefa->titulo }}">
                                            <i class="fas fa-trash"></i>
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

    {{-- MODAL CRIAR --}}
    <div class="modal fade" id="modalCriar" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:var(--cor-primaria)">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-plus-circle me-2"></i> Nova Tarefa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('tarefas.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                                   placeholder="Digite o título..." value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror"
                                      rows="3" placeholder="Descrição opcional...">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Prioridade <span class="text-danger">*</span></label>
                                <select name="prioridade" class="form-select @error('prioridade') is-invalid @enderror" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($prioridade as $p)
                                        <option value="{{ $p->value }}" {{ old('prioridade') == $p->value ? 'selected' : '' }}>
                                            {{ $p->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prioridade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s->value }}" {{ old('status') == $s->value ? 'selected' : '' }}>
                                            {{ $s->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Prazo</label>
                                <input type="date" name="prazo" class="form-control @error('prazo') is-invalid @enderror"
                                       value="{{ old('prazo') }}">
                                @error('prazo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL VER --}}
    <div class="modal fade" id="modalVer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i> Detalhes
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-4 text-muted fw-normal small">Título</dt>
                        <dd class="col-8 fw-semibold" id="ver-titulo">—</dd>
                        <dt class="col-4 text-muted fw-normal small">Descrição</dt>
                        <dd class="col-8" id="ver-descricao">—</dd>
                        <dt class="col-4 text-muted fw-normal small">Prioridade</dt>
                        <dd class="col-8" id="ver-prioridade">—</dd>
                        <dt class="col-4 text-muted fw-normal small">Status</dt>
                        <dd class="col-8" id="ver-status">—</dd>
                        <dt class="col-4 text-muted fw-normal small">Prazo</dt>
                        <dd class="col-8 mb-0" id="ver-prazo">—</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark">
                        <i class="fas fa-edit me-2"></i> Editar Tarefa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formEditar" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="editar-titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" id="editar-descricao" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Prioridade <span class="text-danger">*</span></label>
                                <select name="prioridade" id="editar-prioridade" class="form-select" required>
                                    @foreach($prioridade as $p)
                                        <option value="{{ $p->value }}">{{ $p->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="editar-status" class="form-select" required>
                                    @foreach($status as $s)
                                        <option value="{{ $s->value }}">{{ $s->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Prazo</label>
                                <input type="date" name="prazo" id="editar-prazo" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL APAGAR --}}
    <div class="modal fade" id="modalApagar" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-trash me-2"></i> Confirmar
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="text-muted mb-1 small">Mover para a lixeira:</p>
                    <p class="fw-bold mb-0" id="apagar-titulo">—</p>
                </div>
                <div class="modal-footer justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" id="formApagar" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Mover
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Modal VER
    document.getElementById('modalVer').addEventListener('show.bs.modal', e => {
        const b = e.relatedTarget;
        document.getElementById('ver-titulo').textContent     = b.dataset.titulo;
        document.getElementById('ver-descricao').textContent  = b.dataset.descricao;
        document.getElementById('ver-prioridade').textContent = b.dataset.prioridade;
        document.getElementById('ver-status').textContent     = b.dataset.status;
        document.getElementById('ver-prazo').textContent      = b.dataset.prazo;
    });

    // Modal EDITAR
    document.getElementById('modalEditar').addEventListener('show.bs.modal', e => {
        const b  = e.relatedTarget;
        document.getElementById('formEditar').action          = `/tarefas/${b.dataset.id}`;
        document.getElementById('editar-titulo').value        = b.dataset.titulo;
        document.getElementById('editar-descricao').value     = b.dataset.descricao;
        document.getElementById('editar-prioridade').value    = b.dataset.prioridade;
        document.getElementById('editar-status').value        = b.dataset.status;
        document.getElementById('editar-prazo').value         = b.dataset.prazo;
    });

    // Modal APAGAR
    document.getElementById('modalApagar').addEventListener('show.bs.modal', e => {
        const b = e.relatedTarget;
        document.getElementById('apagar-titulo').textContent  = b.dataset.titulo;
        document.getElementById('formApagar').action          = `/tarefas/${b.dataset.id}`;
    });

    // Auto-fechar toast
    setTimeout(() => {
        const t = document.querySelector('.toast');
        if (t) new bootstrap.Toast(t, { delay: 3000 }).show();
    }, 100);
</script>
@endpush