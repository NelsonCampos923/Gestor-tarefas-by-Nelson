@extends('layouts.app')

@section('titulo', 'Perfil')

@section('topbar-acoes')
    <a href="{{ route('tarefas.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Voltar às Tarefas
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

    <div class="row g-4">

        {{-- COLUNA ESQUERDA — Avatar + Info --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">

                    {{-- Avatar --}}
                    <div class="mb-3" style="position:relative;display:inline-block;">
                        @if(auth()->user()->profile_photo_url)
                            <img src="{{ auth()->user()->profile_photo_url }}"
                                 alt="Foto de perfil"
                                 class="rounded-circle"
                                 style="width:90px;height:90px;object-fit:cover;border:3px solid #e2e8f0;">
                        @else
                            <div style="width:90px;height:90px;border-radius:50%;background:var(--cor-primaria);display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:2rem;font-weight:700;color:#fff;border:3px solid #e2e8f0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>

                    {{-- Stats do utilizador --}}
                    <div class="row g-2 mt-2">
                        <div class="col-4">
                            <div class="rounded-3 p-2" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-bold" style="color:var(--cor-primaria);">
                                    {{ auth()->user()->tarefas()->count() }}
                                </div>
                                <div class="text-muted" style="font-size:0.7rem;">Total</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="rounded-3 p-2" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-bold text-warning">
                                    {{ auth()->user()->tarefas()->where('status','pendente')->count() }}
                                </div>
                                <div class="text-muted" style="font-size:0.7rem;">Pendentes</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="rounded-3 p-2" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-bold text-success">
                                    {{ auth()->user()->tarefas()->where('status','concluida')->count() }}
                                </div>
                                <div class="text-muted" style="font-size:0.7rem;">Feitas</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="text-start">
                        <p class="small text-muted mb-1">
                            <i class="fas fa-calendar-alt me-2" style="color:var(--cor-primaria);"></i>
                            Membro desde {{ auth()->user()->created_at->format('M Y') }}
                        </p>
                        <p class="small text-muted mb-0">
                            <i class="fas fa-circle me-2 text-success" style="font-size:0.5rem;vertical-align:middle;"></i>
                            Conta activa
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- COLUNA DIREITA — Formulários --}}
        <div class="col-md-8">
            <div class="d-flex flex-column gap-4">

                {{-- ACTUALIZAR INFORMAÇÕES --}}
                <div class="card">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-user me-2" style="color:var(--cor-primaria);"></i>
                            Informações Pessoais
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('user-profile-information.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(session('status') === 'profile-information-updated')
                                <div class="alert alert-success py-2 px-3 mt-3 rounded-3 small">
                                    <i class="fas fa-check-circle me-2"></i> Informações actualizadas com sucesso!
                                </div>
                            @endif

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i> Guardar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ALTERAR PASSWORD --}}
                <div class="card">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-lock me-2" style="color:var(--cor-primaria);"></i>
                            Alterar Password
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('user-password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Password Actual</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" id="passActual"
                                               class="form-control border-end-0 @error('current_password') is-invalid @enderror"
                                               placeholder="A tua password actual">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePass('passActual', this)">
                                            <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                                        </button>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nova Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="passNova"
                                               class="form-control border-end-0 @error('password') is-invalid @enderror"
                                               placeholder="Mínimo 8 caracteres">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePass('passNova', this)">
                                            <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirmar Nova Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="passConfirm"
                                               class="form-control border-end-0"
                                               placeholder="Repete a nova password">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePass('passConfirm', this)">
                                            <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if(session('status') === 'password-updated')
                                <div class="alert alert-success py-2 px-3 mt-3 rounded-3 small">
                                    <i class="fas fa-check-circle me-2"></i> Password alterada com sucesso!
                                </div>
                            @endif

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-key me-1"></i> Alterar Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ELIMINAR CONTA --}}
                <div class="card" style="border-color:#fee2e2 !important;">
                    <div class="card-header border-bottom py-3" style="background:#fff5f5;border-color:#fee2e2 !important;">
                        <h6 class="mb-0 fw-bold text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Zona de Perigo
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-3">
                            Ao eliminar a tua conta, todos os dados serão apagados permanentemente. Esta acção não pode ser revertida.
                        </p>
                        <button type="button" class="btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#modalEliminarConta">
                            <i class="fas fa-trash me-1"></i> Eliminar Conta
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL ELIMINAR CONTA --}}
    <div class="modal fade" id="modalEliminarConta" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i> Atenção!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Confirma a tua password para eliminar a conta definitivamente.</p>
                    <form method="POST" action="{{ route('perfil.eliminar') }}" id="formEliminarConta">
                        @csrf
                        
                        @method('DELETE')
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required
                                   placeholder="A tua password">
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-1"></i> Eliminar Definitivamente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    setTimeout(() => {
        const t = document.querySelector('.toast');
        if (t) new bootstrap.Toast(t, { delay: 3000 }).show();
    }, 100);
</script>
@endpush