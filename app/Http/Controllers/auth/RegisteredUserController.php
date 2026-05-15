<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostra o formulário de registo.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Trata o registo de um novo utilizador.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:user,admin'],
        ]);

        // Segurança extra no servidor: se escolheu admin mas não confirmou o código → regista como user
        $role = $request->role;
        if ($role === 'admin' && $request->admin_code_confirmed !== '1') {
            $role = 'user';
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redireciona conforme o role
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        return redirect()->route('tarefas.index');
    }
}