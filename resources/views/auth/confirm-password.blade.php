@extends('layouts.guest')

@section('titulo', 'Confirmar Password')

@section('conteudo')

    <div class="text-center mb-4">
        <div style="width:56px;height:56px;background:rgba(79,70,229,0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="fas fa-shield-alt" style="font-size:1.4rem;color:var(--cor-primaria);"></i>
        </div>
        <h1 class="auth-card-titulo">Confirmar identidade</h1>
        <p class="auth-card-sub">
            Esta é uma área segura. Por favor confirma a tua password para continuar.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 py-2 px-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $erro)
                <span class="small">{{ $erro }}</span>
            @endforeach
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border"
                      style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                    <i class="fas fa-lock text-muted" style="font-size:0.8rem;"></i>
                </span>
                <input type="password" name="password" id="inputPassword"
                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                       placeholder="A tua password" required autofocus>
                <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword('inputPassword', this)">
                    <i class="fas fa-eye" style="font-size:0.8rem;"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-auth">
            <i class="fas fa-check-circle me-2"></i> Confirmar
        </button>
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