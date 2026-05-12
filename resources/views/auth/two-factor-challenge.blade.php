@extends('layouts.guest')

@section('titulo', 'Autenticação de Dois Factores')

@section('conteudo')

    <div class="text-center mb-4">
        <div style="width:56px;height:56px;background:rgba(79,70,229,0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i class="fas fa-mobile-alt" style="font-size:1.4rem;color:var(--cor-primaria);"></i>
        </div>
        <h1 class="auth-card-titulo">Verificação 2FA</h1>
        <p class="auth-card-sub" id="subtitulo-2fa">
            Insere o código gerado pela tua aplicação de autenticação.
        </p>
    </div>

    {{-- Formulário código --}}
    <div id="form-codigo">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Código de Autenticação</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 border"
                          style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                        <i class="fas fa-key text-muted" style="font-size:0.8rem;"></i>
                    </span>
                    <input type="text" name="code"
                           class="form-control border-start-0 @error('code') is-invalid @enderror"
                           style="border-radius:0 0.5rem 0.5rem 0;letter-spacing:0.3em;text-align:center;font-size:1.1rem;"
                           placeholder="000 000"
                           maxlength="6"
                           inputmode="numeric"
                           autocomplete="one-time-code"
                           autofocus>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-auth">
                <i class="fas fa-sign-in-alt me-2"></i> Verificar e Entrar
            </button>
        </form>
    </div>

    {{-- Formulário código de recuperação --}}
    <div id="form-recuperacao" style="display:none;">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Código de Recuperação</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 border"
                          style="border-radius:0.5rem 0 0 0.5rem;border-color:#e2e8f0;">
                        <i class="fas fa-life-ring text-muted" style="font-size:0.8rem;"></i>
                    </span>
                    <input type="text" name="recovery_code"
                           class="form-control border-start-0 @error('recovery_code') is-invalid @enderror"
                           style="border-radius:0 0.5rem 0.5rem 0;"
                           placeholder="xxxx-xxxx-xxxx"
                           autocomplete="one-time-code">
                    @error('recovery_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-auth">
                <i class="fas fa-sign-in-alt me-2"></i> Entrar com Código de Recuperação
            </button>
        </form>
    </div>

    <div class="divider">ou</div>

    <p class="text-center mb-0">
        <button type="button" class="btn btn-link auth-link p-0 small" id="btn-alternar">
            <i class="fas fa-life-ring me-1"></i> Usar código de recuperação
        </button>
    </p>

@endsection

@push('scripts')
<script>
    const btnAlternar      = document.getElementById('btn-alternar');
    const formCodigo       = document.getElementById('form-codigo');
    const formRecuperacao  = document.getElementById('form-recuperacao');
    const subtitulo        = document.getElementById('subtitulo-2fa');

    let modoRecuperacao = false;

    btnAlternar.addEventListener('click', () => {
        modoRecuperacao = !modoRecuperacao;

        if (modoRecuperacao) {
            formCodigo.style.display      = 'none';
            formRecuperacao.style.display = 'block';
            subtitulo.textContent         = 'Insere um dos teus códigos de recuperação.';
            btnAlternar.innerHTML         = '<i class="fas fa-mobile-alt me-1"></i> Usar código da aplicação';
        } else {
            formCodigo.style.display      = 'block';
            formRecuperacao.style.display = 'none';
            subtitulo.textContent         = 'Insere o código gerado pela tua aplicação de autenticação.';
            btnAlternar.innerHTML         = '<i class="fas fa-life-ring me-1"></i> Usar código de recuperação';
        }
    });
</script>
@endpush