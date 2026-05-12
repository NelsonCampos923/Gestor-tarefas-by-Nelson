@extends('layouts.guest')

@section('titulo', 'Verificar Email')

@section('conteudo')

    <div class="text-center mb-4">
        <div style="width:56px;height:56px;background:rgba(16,185,129,0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="fas fa-envelope-open-text" style="font-size:1.4rem;color:#10b981;"></i>
        </div>
        <h1 class="auth-card-titulo">Verifica o teu email</h1>
        <p class="auth-card-sub">
            Enviámos um link de verificação para o teu endereço de email.
            Clica no link para activares a tua conta.
        </p>
    </div>

    {{-- Sucesso --}}
    @if(session('status') == 'verification-link-sent')
        <div class="alert alert-success rounded-3 py-2 px-3 mb-4 text-center">
            <i class="fas fa-check-circle me-2"></i>
            <span class="small">Novo link de verificação enviado com sucesso!</span>
        </div>
    @endif

    {{-- Info --}}
    <div class="rounded-3 p-3 mb-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
        <p class="small text-muted mb-2">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Não encontras o email? Verifica a pasta de <strong>spam</strong> ou solicita um novo link.
        </p>
        <p class="small text-muted mb-0">
            <i class="fas fa-user me-2" style="color:#94a3b8;"></i>
            Email enviado para: <strong>{{ auth()->user()->email }}</strong>
        </p>
    </div>

    {{-- Reenviar --}}
    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-auth">
            <i class="fas fa-paper-plane me-2"></i> Reenviar Email de Verificação
        </button>
    </form>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-100 btn btn-outline-secondary" style="border-radius:0.5rem;font-size:0.875rem;font-weight:500;">
            <i class="fas fa-sign-out-alt me-2"></i> Terminar Sessão
        </button>
    </form>

@endsection