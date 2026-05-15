<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redireciona após LOGIN conforme o role
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    if (auth()->user()->isAdmin()) {
                        return redirect()->route('admin.index');
                    }
                    return redirect()->route('tarefas.index');
                }
            };
        });

        // Redireciona após REGISTO conforme o role
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    if (auth()->user()->isAdmin()) {
                        return redirect()->route('admin.index');
                    }
                    return redirect()->route('tarefas.index');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}