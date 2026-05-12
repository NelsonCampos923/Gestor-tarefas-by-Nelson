@extends('layouts.guest')

@section('titulo', 'Entrar')

@section('conteudo')

    <h1 class="auth-card-titulo">Bem-vindo de volta!</h1>
    <p class="auth-card-sub">Inicia sessão para aceder às tuas tarefas.</p>

    {{-- Erros gerais --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 py-2 px-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $erro)
                <span class="small">{{ $erro }}</span>
            @endforeach
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
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

        {{-- Password --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label mb-0">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.8rem;">
                        Esqueceste a password?
                    </a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-lock text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="password" name="password" id="inputPassword"
                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                       placeholder="A tua password"
                       required>
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword('inputPassword', this)">
                    <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Lembrar --}}
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small text-muted" for="remember">
                    Manter sessão iniciada
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-auth">
            <i class="fas fa-sign-in-alt me-2"></i> Entrar
        </button>

        <div class="divider">ou</div>

        <p class="text-center text-muted small mb-0">
            Não tens conta?
            <a href="{{ route('register') }}" class="auth-link">Criar conta grátis</a>
        </p>
    </form>

@endsection

@push('scripts')
<script>
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