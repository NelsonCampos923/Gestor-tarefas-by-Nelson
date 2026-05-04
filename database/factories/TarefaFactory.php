<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarefaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'titulo'     => $this->faker->sentence(4),
            'descricao'  => $this->faker->paragraph(),
            'prioridade' => $this->faker->randomElement(['baixa', 'media', 'alta']),
            'status'     => $this->faker->randomElement(['pendente', 'progresso', 'concluida']),
            'prazo'      => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }
}