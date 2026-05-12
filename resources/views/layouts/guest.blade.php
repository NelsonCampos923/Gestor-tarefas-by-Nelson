<!DOCTYPE html>

<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Gestor de Tarefas') }} — @yield('titulo')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cor-primaria:   #4f46e5;
            --cor-secundaria: #6366f1;
        }

        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #f1f5f9;
        }

        /* ── PAINEL ESQUERDO ─────────────────────── */
        .auth-banner {
            width: 45%;
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 60%, #6366f1 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .auth-banner::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -100px;
            right: -100px;
        }

        .auth-banner::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px;
            left: -80px;
        }

        .banner-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 1;
        }

        .banner-logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .banner-logo-icon i {
            color: #fff;
            font-size: 1.1rem;
        }

        .banner-logo-text {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .banner-content {
            z-index: 1;
        }

        .banner-titulo {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .banner-subtitulo {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
        }

        .banner-features {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0 0;
        }

        .banner-features li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
        }

        .banner-features li i {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.12);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .banner-footer {
            z-index: 1;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.35);
        }

        /* ── PAINEL DIREITO (FORM) ───────────────── */
        .auth-form-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        .auth-card-titulo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .auth-card-sub {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 0.825rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.35rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            padding: 0.65rem 0.875rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .btn-outline-secondary {
            border-color: #e2e8f0;
            color: #94a3b8;
            background: #fff;
            border-radius: 0 0.5rem 0.5rem 0 !important;
        }

        .input-group .btn-outline-secondary:hover {
            background: #f8fafc;
            color: #4f46e5;
        }

        .btn-auth {
            background: var(--cor-primaria);
            border: none;
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.7rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            width: 100%;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-auth:hover {
            background: var(--cor-secundaria);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .auth-link {
            color: var(--cor-primaria);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link:hover {
            color: var(--cor-secundaria);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #94a3b8;
            font-size: 0.8rem;
            margin: 1.25rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── RESPONSIVO ──────────────────────────── */
        @media (max-width: 768px) {
            .auth-banner {
                display: none;
            }

            .auth-form-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    {{-- Painel esquerdo --}}
    <div class="auth-banner d-none d-md-flex">
        <div class="banner-logo">
            <div class="banner-logo-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <span class="banner-logo-text">Gestor de Tarefas</span>
        </div>

        <div class="banner-content">
            <h1 class="banner-titulo">
                Organiza o teu<br> trabalho com<br> facilidade.
            </h1>
            <p class="banner-subtitulo">
                Gere as tuas tarefas de forma simples,<br>
                acompanha o progresso e cumpre os teus prazos.
            </p>
            <ul class="banner-features">
                <li>
                    <i class="fas fa-check"></i>
                    Cria e organiza tarefas por prioridade
                </li>
                <li>
                    <i class="fas fa-shield-alt"></i>
                    As tuas tarefas são privadas e seguras
                </li>
                <li>
                    <i class="fas fa-chart-line"></i>
                    Acompanha o progresso em tempo real
                </li>
                <li>
                    <i class="fas fa-undo"></i>
                    Lixeira com restauro de tarefas
                </li>
            </ul>
        </div>

        <div class="banner-footer">
            © {{ date('Y') }} Gestor de Tarefas. Todos os direitos reservados.
        </div>
    </div>

    {{-- Painel direito --}}
    <div class="auth-form-wrapper">
        <div class="auth-card">
            @yield('conteudo')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>