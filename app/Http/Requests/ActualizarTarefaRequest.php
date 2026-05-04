<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarTarefaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'     => 'required|min:3|max:255',
            'descricao'  => 'nullable|max:1000',
            'prioridade' => 'required|in:baixa,media,alta',
            'status'     => 'required|in:pendente,progresso,concluida',
            'prazo'      => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'     => 'O título é obrigatório.',
            'titulo.min'          => 'O título deve ter pelo menos 3 caracteres.',
            'prioridade.required' => 'Selecciona uma prioridade.',
            'prioridade.in'       => 'Prioridade inválida.',
            'status.required'     => 'Selecciona um status.',
            'status.in'           => 'Status inválido.',
        ];
    }
}