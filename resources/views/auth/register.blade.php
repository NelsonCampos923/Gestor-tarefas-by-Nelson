<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Gestor de Tarefas</title>

    {{-- Bootstrap local --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --cor-primaria: #4f46e5;
            --cor-primaria-hover: #4338ca;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 480px;
        }

        .auth-logo {
            width: 48px;
            height: 48px;
            background: var(--cor-primaria);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .auth-logo i { color: #fff; font-size: 1.4rem; }

        h1 { font-size: 1.4rem; font-weight: 700; color: #1e293b; text-align: center; }
        .subtitle { color: #64748b; font-size: .875rem; text-align: center; margin-top: .25rem; margin-bottom: 1.75rem; }

        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: .5rem;
            padding: .6rem .85rem;
            font-size: .875rem;
            transition: border-color .2s;
        }

        .form-control:focus {
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px rgba(79,70,229,.1);
        }

        /* Role selector */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-top: .25rem;
        }

        .role-option {
            position: relative;
            cursor: pointer;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
        }

        .role-card {
            border: 2px solid #e2e8f0;
            border-radius: .65rem;
            padding: .9rem .75rem;
            text-align: center;
            transition: all .2s;
            background: #f8fafc;
            user-select: none;
        }

        .role-card i {
            font-size: 1.4rem;
            margin-bottom: .4rem;
            display: block;
            color: #94a3b8;
            transition: color .2s;
        }

        .role-card .role-name {
            font-weight: 700;
            font-size: .8rem;
            color: #374151;
        }

        .role-card .role-desc {
            font-size: .7rem;
            color: #94a3b8;
            margin-top: .15rem;
        }

        .role-option input:checked + .role-card {
            border-color: var(--cor-primaria);
            background: #eef2ff;
        }

        .role-option input:checked + .role-card i {
            color: var(--cor-primaria);
        }

        /* Botão submit */
        .btn-primario {
            background: var(--cor-primaria);
            color: #fff;
            border: none;
            border-radius: .5rem;
            padding: .7rem 1rem;
            font-size: .9rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }

        .btn-primario:hover { background: var(--cor-primaria-hover); }
        .btn-primario:active { transform: scale(.98); }

        .link-login {
            text-align: center;
            font-size: .8rem;
            color: #64748b;
            margin-top: 1.25rem;
        }

        .link-login a {
            color: var(--cor-primaria);
            font-weight: 600;
            text-decoration: none;
        }

        /* Modal código admin */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal-box {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            animation: slideUp .25s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        .modal-icon {
            width: 52px;
            height: 52px;
            background: #fef3c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .modal-icon i { color: #d97706; font-size: 1.3rem; }

        .modal-title {
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
            color: #1e293b;
        }

        .modal-desc {
            text-align: center;
            font-size: .8rem;
            color: #64748b;
            margin: .5rem 0 1.25rem;
        }

        .codigo-input {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: .5rem;
            border: 2px solid #e2e8f0;
            border-radius: .5rem;
            padding: .65rem;
            width: 100%;
            color: #1e293b;
            transition: border-color .2s;
        }

        .codigo-input:focus {
            outline: none;
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px rgba(79,70,229,.1);
        }

        .codigo-input.erro { border-color: #ef4444; }
        .codigo-input.sucesso { border-color: #22c55e; }

        .msg-erro {
            display: none;
            color: #ef4444;
            font-size: .75rem;
            text-align: center;
            margin-top: .5rem;
        }

        .modal-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-top: 1.25rem;
        }

        .btn-cancelar {
            border: 1.5px solid #e2e8f0;
            background: #fff;
            border-radius: .5rem;
            padding: .6rem;
            font-size: .85rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-cancelar:hover { background: #f8fafc; }

        .btn-confirmar {
            background: var(--cor-primaria);
            color: #fff;
            border: none;
            border-radius: .5rem;
            padding: .6rem;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-confirmar:hover { background: var(--cor-primaria-hover); }

        /* Erro Laravel */
        .alert-erro {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: .5rem;
            padding: .75rem 1rem;
            font-size: .8rem;
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .invalid-feedback { font-size: .75rem; }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="auth-logo">
        <i class="fas fa-check-double"></i>
    </div>

    <h1>Criar Conta</h1>
    <p class="subtitle">Preenche os dados para começar</p>

    {{-- Erros gerais --}}
    @if($errors->any())
        <div class="alert-erro">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="formRegisto">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome completo</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   placeholder="O teu nome" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="exemplo@email.com" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Mínimo 8 caracteres" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirmar password --}}
        <div class="mb-4">
            <label class="form-label">Confirmar Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control"
                   placeholder="Repete a password" required>
        </div>

        {{-- Escolha de role --}}
        <div class="mb-4">
            <label class="form-label d-block mb-2">Tipo de conta</label>
            <div class="role-selector">

                <label class="role-option">
                    <input type="radio" name="role" value="user" id="roleUser"
                           {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                    <div class="role-card">
                        <i class="fas fa-user"></i>
                        <div class="role-name">Utilizador</div>
                        <div class="role-desc">Gere as tuas tarefas</div>
                    </div>
                </label>

                <label class="role-option">
                    <input type="radio" name="role" value="admin" id="roleAdmin"
                           {{ old('role') === 'admin' ? 'checked' : '' }}>
                    <div class="role-card">
                        <i class="fas fa-shield-alt"></i>
                        <div class="role-name">Administrador</div>
                        <div class="role-desc">Acesso total ao sistema</div>
                    </div>
                </label>

            </div>
        </div>

        {{-- Campo oculto para confirmar que o código foi validado --}}
        <input type="hidden" name="admin_code_confirmed" id="adminCodeConfirmed" value="0">

        <button type="submit" class="btn-primario">
            <i class="fas fa-user-plus me-2"></i> Criar Conta
        </button>
    </form>

    <p class="link-login">
        Já tens conta? <a href="{{ route('login') }}">Entrar</a>
    </p>

</div>


{{-- MODAL CÓDIGO ADMIN --}}
<div class="modal-overlay" id="modalCodigoAdmin">
    <div class="modal-box">
        <div class="modal-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="modal-title">Código de Administrador</div>
        <div class="modal-desc">
            Introduz o código de acesso para criar uma conta de administrador.
        </div>

        <input type="text" class="codigo-input" id="codigoInput"
               maxlength="8" placeholder="········" autocomplete="off">
        <div class="msg-erro" id="msgErroCodigo">
            <i class="fas fa-times-circle me-1"></i> Código incorrecto. Tenta novamente.
        </div>

        <div class="modal-actions">
            <button class="btn-cancelar" id="btnCancelarCodigo">Cancelar</button>
            <button class="btn-confirmar" id="btnConfirmarCodigo">Confirmar</button>
        </div>
    </div>
</div>


<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    const CODIGO_ADMIN = '12345678';

    const radioAdmin     = document.getElementById('roleAdmin');
    const radioUser      = document.getElementById('roleUser');
    const modal          = document.getElementById('modalCodigoAdmin');
    const codigoInput    = document.getElementById('codigoInput');
    const msgErro        = document.getElementById('msgErroCodigo');
    const btnCancelar    = document.getElementById('btnCancelarCodigo');
    const btnConfirmar   = document.getElementById('btnConfirmarCodigo');
    const adminConfirmed = document.getElementById('adminCodeConfirmed');
    const form           = document.getElementById('formRegisto');

    // Quando clica em Admin → abre modal
    radioAdmin.addEventListener('change', function () {
        if (this.checked && adminConfirmed.value !== '1') {
            abrirModal();
        }
    });

    function abrirModal() {
        codigoInput.value = '';
        codigoInput.classList.remove('erro', 'sucesso');
        msgErro.style.display = 'none';
        modal.classList.add('active');
        setTimeout(() => codigoInput.focus(), 100);
    }

    function fecharModal() {
        modal.classList.remove('active');
    }

    // Cancelar → volta para User
    btnCancelar.addEventListener('click', function () {
        fecharModal();
        radioUser.checked = true;
        adminConfirmed.value = '0';
    });

    // Confirmar código
    btnConfirmar.addEventListener('click', validarCodigo);

    // Enter no input
    codigoInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') validarCodigo();
    });

    // Feedback visual ao digitar
    codigoInput.addEventListener('input', function () {
        this.classList.remove('erro', 'sucesso');
        msgErro.style.display = 'none';
    });

    function validarCodigo() {
        const valor = codigoInput.value.trim();

        if (valor === CODIGO_ADMIN) {
            codigoInput.classList.add('sucesso');
            adminConfirmed.value = '1';
            setTimeout(fecharModal, 400);
        } else {
            codigoInput.classList.add('erro');
            msgErro.style.display = 'block';
            codigoInput.value = '';
            codigoInput.focus();
        }
    }

    // Interceptar submit — se escolheu admin mas não confirmou
    form.addEventListener('submit', function (e) {
        if (radioAdmin.checked && adminConfirmed.value !== '1') {
            e.preventDefault();
            abrirModal();
        }
    });

    // Fechar modal ao clicar fora
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            fecharModal();
            radioUser.checked = true;
            adminConfirmed.value = '0';
        }
    });
</script>

</body>
</html>