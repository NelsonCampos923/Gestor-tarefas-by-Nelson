@extends('layouts.guest')

@section('titulo', 'Recuperar Password')

@section('conteudo')

    <a href="{{ route('login') }}" class="auth-link d-inline-flex align-items-center gap-1 mb-4" style="font-size:0.85rem;">
        <i class="fas fa-arrow-left" style="font-size:0.75rem;"></i> Voltar ao login
    </a>

    <h1 class="auth-card-titulo">Recuperar password</h1>
    <p class="auth-card-sub">
        Indica o teu email e enviamos um link para redefinires a tua password.
    </p>

    @if(session('status'))
        <div class="alert alert-success rounded-3 py-2 px-3 mb-3">
            <i class="fas fa-check-circle me-2"></i>
            <span class="small">{{ session('status') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 py-2 px-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $erro)
                <span class="small">{{ $erro }}</span>
            @endforeach
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-envelope text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="email" name="email"
                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                       style="border-radius:0 0.5rem 0.5rem 0;"
                       placeholder="o-teu@email.com"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-auth">
            <i class="fas fa-paper-plane me-2"></i> Enviar Link de Recuperação
        </button>
    </form>

@endsection