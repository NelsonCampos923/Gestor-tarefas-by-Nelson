<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestor de Tarefas') }} — @yield('titulo', 'Dashboard')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Estilos Globais --}}
    <style>
        :root {
            --cor-primaria:    #4f46e5;
            --cor-secundaria:  #6366f1;
            --cor-fundo:       #f1f5f9;
            --cor-sidebar:     #1e1b4b;
            --cor-texto:       #1e293b;
            --cor-muted:       #94a3b8;
            --sidebar-largura: 260px;
            --header-altura:   64px;
        }

        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: var(--cor-fundo);
            color: var(--cor-texto);
            min-height: 100vh;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-largura);
            min-height: 100vh;
            background: var(--cor-sidebar);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-logo span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .sidebar-logo small {
            display: block;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            margin-top: 2px;
        }

        .sidebar-nav {
            padding: 1rem 0.75rem;
            flex: 1;
        }

        .sidebar-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.3);
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            border-radius: 0.5rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--cor-primaria);
            color: #fff;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 0.875rem;
        }

        /* Link admin — destaque subtil */
        .sidebar-link.admin-link {
            color: #fbbf24;
        }

        .sidebar-link.admin-link:hover {
            background: rgba(251,191,36,0.12);
            color: #fbbf24;
        }

        .sidebar-link.admin-link.active {
            background: #d97706;
            color: #fff;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.05);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--cor-primaria);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .user-email {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
        }

        /* Badge role na sidebar */
        .role-badge {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: auto;
        }

        .role-badge.admin {
            background: rgba(251,191,36,0.2);
            color: #fbbf24;
            border: 1px solid rgba(251,191,36,0.3);
        }

        /* ── CONTEÚDO PRINCIPAL ──────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-largura);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ──────────────────────────────── */
        .topbar {
            height: var(--header-altura);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-titulo {
            font-size: 1rem;
            font-weight: 600;
            color: var(--cor-texto);
        }

        .page-content {
            padding: 1.75rem 1.5rem;
            flex: 1;
        }

        /* ── CARDS ───────────────────────────────── */
        .card {
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
        }

        .card-stat {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 1.25rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .stat-valor {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.78rem;
            color: var(--cor-muted);
            margin-top: 4px;
        }

        /* ── TABELA ──────────────────────────────── */
        .table thead th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--cor-muted);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.875rem 1rem;
        }

        .table tbody td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* ── BADGES ──────────────────────────────── */
        .badge {
            font-weight: 500;
            font-size: 0.72rem;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
        }

        /* ── BOTÕES ──────────────────────────────── */
        .btn {
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
        }

        .btn-primary {
            background: var(--cor-primaria);
            border-color: var(--cor-primaria);
        }

        .btn-primary:hover {
            background: var(--cor-secundaria);
            border-color: var(--cor-secundaria);
        }

        /* ── FORMULÁRIOS ─────────────────────────── */
        .form-control, .form-select {
            border-radius: 0.5rem;
            border-color: #e2e8f0;
            font-size: 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .form-label {
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--cor-texto);
            margin-bottom: 0.35rem;
        }

        /* ── MODAIS ──────────────────────────────── */
        .modal-content {
            border-radius: 0.875rem !important;
            border: none !important;
        }

        .modal-header {
            border-radius: 0.875rem 0.875rem 0 0 !important;
            padding: 1rem 1.25rem;
        }

        /* ── TOAST ───────────────────────────────── */
        .toast {
            border-radius: 0.625rem;
            font-size: 0.875rem;
        }

        /* ── MOBILE ──────────────────────────────── */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.aberta {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }

            .overlay.visivel {
                display: block;
            }
        }
    </style>

    @stack('estilos')
</head>
<body>

    {{-- OVERLAY MOBILE --}}
    <div class="overlay" id="overlay" onclick="fecharSidebar()"></div>

    {{-- ── SIDEBAR ─────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <div class="d-flex align-items-center gap-2">
                <div style="width:32px;height:32px;background:var(--cor-primaria);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-tasks text-white" style="font-size:0.875rem;"></i>
                </div>
                <div>
                    <span>Gestor de Tarefas</span>
                    <small>Painel pessoal</small>
                </div>
            </div>
        </div>

        {{-- Navegação --}}
        <nav class="sidebar-nav">
            <div class="sidebar-label">Menu</div>

            <a href="{{ route('tarefas.index') }}"
               class="sidebar-link {{ request()->routeIs('tarefas.index') ? 'active' : '' }}">
                <i class="fas fa-list-check"></i> Minhas Tarefas
            </a>

            <a href="{{ route('tarefas.lixeira') }}"
               class="sidebar-link {{ request()->routeIs('tarefas.lixeira') ? 'active' : '' }}">
                <i class="fas fa-trash-alt"></i> Lixeira
            </a>

            <div class="sidebar-label mt-2">Conta</div>

            <a href="{{ route('profile.show') }}"
               class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Perfil
            </a>

            {{-- Link Admin — visível apenas para administradores --}}
            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="sidebar-label mt-2">Administração</div>

                <a href="{{ route('admin.index') }}"
                   class="sidebar-link admin-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fas fa-shield-alt"></i>
                    Painel Admin
                    <span class="role-badge admin">Admin</span>
                </a>
            @endif
        </nav>

        {{-- Footer do utilizador --}}
        <div class="sidebar-footer">
            <div class="user-info mb-2">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start">
                    <i class="fas fa-sign-out-alt"></i> Terminar Sessão
                </button>
            </form>
        </div>
    </aside>

    {{-- ── CONTEÚDO PRINCIPAL ───────────────────── --}}
    <div class="main-wrapper">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary sidebar-toggle" onclick="abrirSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-titulo">@yield('titulo', 'Dashboard')</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                {{-- Badge admin na topbar --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                    <span class="badge"
                          style="background:rgba(217,119,6,0.12);color:#d97706;border:1px solid rgba(217,119,6,0.25);font-size:0.65rem;">
                        <i class="fas fa-shield-alt me-1"></i> Admin
                    </span>
                @endif
                @yield('topbar-acoes')
            </div>
        </header>

        {{-- Conteúdo --}}
        <main class="page-content">
            @yield('conteudo')
        </main>

    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script global sidebar mobile --}}
    <script>
        function abrirSidebar() {
            document.getElementById('sidebar').classList.add('aberta');
            document.getElementById('overlay').classList.add('visivel');
        }

        function fecharSidebar() {
            document.getElementById('sidebar').classList.remove('aberta');
            document.getElementById('overlay').classList.remove('visivel');
        }
    </script>

    @stack('scripts')
</body>
</html>