@extends('layouts.guest')

@section('titulo', 'Criar Conta')

@section('conteudo')

    <h1 class="auth-card-titulo">Criar conta</h1>
    <p class="auth-card-sub">Regista-te gratuitamente e começa a organizar.</p>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 py-2 px-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $erro)
                <span class="small d-block">{{ $erro }}</span>
            @endforeach
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome completo</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
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
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
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
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
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
        <div class="mb-4">
            <label class="form-label">Confirmar Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
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

        <button type="submit" class="btn btn-auth">
            <i class="fas fa-user-plus me-2"></i> Criar Conta
        </button>

        <div class="divider">ou</div>

        <p class="text-center text-muted small mb-0">
            Já tens conta?
            <a href="{{ route('login') }}" class="auth-link">Entrar</a>
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