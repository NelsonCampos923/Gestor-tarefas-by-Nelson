<?php

namespace Database\Seeders;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utilizador de teste fixo
        $utilizador = User::factory()->create([
            'name'     => 'Barros',
            'email'    => 'barros@teste.com',
            'password' => bcrypt('password'),
        ]);

        // 15 tarefas para o utilizador de teste
        Tarefa::factory(15)->create(['user_id' => $utilizador->id]);

        // 3 utilizadores aleatórios com 10 tarefas cada
        User::factory(3)
            ->has(Tarefa::factory(10))
            ->create();
    }
}