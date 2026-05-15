@extends('layouts.guest')

@section('titulo', 'Criar Conta')

@section('conteudo')

    <h1 class="auth-card-titulo">Criar conta</h1>
    <p class="auth-card-sub">Preenche os dados para começar.</p>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 py-2 px-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $erro)
                <span class="small d-block">{{ $erro }}</span>
            @endforeach
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="formRegisto">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome completo</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border"
                      style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-user text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="text" name="name"
                       class="form-control border-start-0 @error('name') is-invalid @enderror"
                       style="border-radius:0 0.5rem 0.5rem 0;"
                       placeholder="O teu nome"
                       value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border"
                      style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-envelope text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="email" name="email"
                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                       style="border-radius:0 0.5rem 0.5rem 0;"
                       placeholder="o-teu@email.com"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border"
                      style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-lock text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="password" name="password" id="inputPassword"
                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                       placeholder="Mínimo 8 caracteres" required>
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword('inputPassword', this)">
                    <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Confirmar Password --}}
        <div class="mb-3">
            <label class="form-label">Confirmar Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border"
                      style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-lock text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="password" name="password_confirmation" id="inputConfirm"
                       class="form-control border-start-0 border-end-0"
                       placeholder="Repete a password" required>
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword('inputConfirm', this)">
                    <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                </button>
            </div>
        </div>

        {{-- Tipo de Conta --}}
        <div class="mb-4">
            <label class="form-label d-block mb-2">Tipo de conta</label>
            <div class="row g-2">

                {{-- Utilizador --}}
                <div class="col-6">
                    <div id="cardUser"
                         onclick="seleccionarRole('user')"
                         class="role-card activo text-center p-3 rounded-3"
                         style="cursor:pointer;">
                        <i class="fas fa-user d-block mb-2" style="font-size:1.3rem;"></i>
                        <div style="font-size:0.8rem;font-weight:700;">Utilizador</div>
                        <div style="font-size:0.7rem;color:#94a3b8;margin-top:2px;">Gere as tuas tarefas</div>
                    </div>
                </div>

                {{-- Administrador --}}
                <div class="col-6">
                    <div id="cardAdmin"
                         onclick="clicarAdmin()"
                         class="role-card text-center p-3 rounded-3"
                         style="cursor:pointer;">
                        <i class="fas fa-shield-alt d-block mb-2" style="font-size:1.3rem;"></i>
                        <div style="font-size:0.8rem;font-weight:700;">Administrador</div>
                        <div style="font-size:0.7rem;color:#94a3b8;margin-top:2px;">Acesso total</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Campos ocultos --}}
        <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'user') }}">
        <input type="hidden" name="admin_code_confirmed" id="adminCodeConfirmed" value="0">

        <button type="submit" class="btn btn-auth">
            <i class="fas fa-user-plus me-2"></i> Criar Conta
        </button>

        <div class="divider">ou</div>

        <p class="text-center text-muted small mb-0">
            Já tens conta?
            <a href="{{ route('login') }}" class="auth-link">Entrar</a>
        </p>
    </form>

    {{-- MODAL CÓDIGO ADMIN --}}
    <div class="modal fade" id="modalCodigoAdmin" tabindex="-1"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius:1rem;">
                <div class="modal-body p-4 text-center">

                    <div style="width:52px;height:52px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <i class="fas fa-lock" style="color:#d97706;font-size:1.2rem;"></i>
                    </div>

                    <h6 class="fw-bold mb-1" style="color:#1e293b;">Código de Administrador</h6>
                    <p class="text-muted mb-3" style="font-size:0.8rem;">
                        Introduz o código de acesso para criar uma conta de administrador.
                    </p>

                    <input type="text" id="codigoInput"
                           class="codigo-input"
                           maxlength="8"
                           placeholder="········"
                           autocomplete="off">

                    <div id="msgErroCodigo"
                         style="display:none;color:#ef4444;font-size:0.75rem;margin-top:0.5rem;">
                        <i class="fas fa-times-circle me-1"></i> Código incorrecto.
                    </div>

                    <div class="row g-2 mt-3">
                        <div class="col-6">
                            <button type="button"
                                    class="btn btn-outline-secondary w-100 btn-sm"
                                    id="btnCancelarCodigo">
                                Cancelar
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button"
                                    class="btn btn-primary w-100 btn-sm"
                                    id="btnConfirmarCodigo">
                                Confirmar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('estilos')
<style>
    .role-card {
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        color: #374151;
        transition: all 0.2s;
        height: 100%;
    }

    .role-card i { color: #94a3b8; transition: color 0.2s; }

    .role-card.activo {
        border-color: var(--cor-primaria) !important;
        background: #eef2ff !important;
    }

    .role-card.activo i {
        color: var(--cor-primaria) !important;
    }

    .role-card:hover {
        border-color: var(--cor-primaria);
        opacity: 0.85;
    }

    .codigo-input {
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.65rem;
        width: 100%;
        color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }

    .codigo-input:focus {
        border-color: var(--cor-primaria);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .codigo-input.erro    { border-color: #ef4444; animation: shake 0.3s ease; }
    .codigo-input.sucesso { border-color: #22c55e; }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25%       { transform: translateX(-6px); }
        75%       { transform: translateX(6px); }
    }
</style>
@endpush

@push('scripts')
<script>
    const CODIGO_ADMIN   = '12345678';
    const roleInput      = document.getElementById('roleInput');
    const adminConfirmed = document.getElementById('adminCodeConfirmed');
    const cardUser       = document.getElementById('cardUser');
    const cardAdmin      = document.getElementById('cardAdmin');
    const codigoInput    = document.getElementById('codigoInput');
    const msgErro        = document.getElementById('msgErroCodigo');
    const form           = document.getElementById('formRegisto');
    const modalEl        = document.getElementById('modalCodigoAdmin');
    const modal          = new bootstrap.Modal(modalEl);

    // Seleccionar Utilizador
    function seleccionarRole(role) {
        roleInput.value = role;
        cardUser.classList.toggle('activo', role === 'user');
        cardAdmin.classList.toggle('activo', role === 'admin');
        if (role === 'user') adminConfirmed.value = '0';
    }

    // Clicar em Administrador → abre modal
    function clicarAdmin() {
        if (adminConfirmed.value === '1') {
            seleccionarRole('admin');
            return;
        }
        codigoInput.value = '';
        codigoInput.classList.remove('erro', 'sucesso');
        msgErro.style.display = 'none';
        modal.show();
        setTimeout(() => codigoInput.focus(), 300);
    }

    // Cancelar → volta a Utilizador
    document.getElementById('btnCancelarCodigo').addEventListener('click', () => {
        modal.hide();
        seleccionarRole('user');
        adminConfirmed.value = '0';
    });

    // Confirmar código
    document.getElementById('btnConfirmarCodigo').addEventListener('click', validarCodigo);

    codigoInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') validarCodigo();
    });

    codigoInput.addEventListener('input', () => {
        codigoInput.classList.remove('erro', 'sucesso');
        msgErro.style.display = 'none';
    });

    function validarCodigo() {
        if (codigoInput.value.trim() === CODIGO_ADMIN) {
            codigoInput.classList.add('sucesso');
            adminConfirmed.value = '1';
            setTimeout(() => {
                modal.hide();
                seleccionarRole('admin');
            }, 400);
        } else {
            codigoInput.classList.add('erro');
            msgErro.style.display = 'block';
            codigoInput.value = '';
            setTimeout(() => codigoInput.focus(), 50);
        }
    }

    // Interceptar submit
    form.addEventListener('submit', e => {
        if (roleInput.value === 'admin' && adminConfirmed.value !== '1') {
            e.preventDefault();
            clicarAdmin();
        }
    });

    // Toggle password
    function togglePassword(inputId, btn) {
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
</script>
@endpush