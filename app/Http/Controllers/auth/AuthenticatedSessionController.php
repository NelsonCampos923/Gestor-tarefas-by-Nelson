<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostra o formulário de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Trata o login do utilizador.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Redireciona conforme o role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.index'));
        }

        return redirect()->intended(route('tarefas.index'));
    }

    /**
     * Termina a sessão do utilizador.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}