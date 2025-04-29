<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRepresentativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => [
                'required',
                'string',
                'size:14',
                Rule::unique('representatives', 'cpf')->ignore($this->route('representative')),
            ],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:M,F'],
            'address' => ['nullable', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.size' => 'O campo CPF deve ter exatamente 14 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'birth_date.required' => 'O campo Data de Nascimento é obrigatório.',
            'birth_date.date' => 'O campo Data de Nascimento deve ser uma data válida.',
            'gender.required' => 'O campo Gênero é obrigatório.',
            'gender.in' => 'O campo Gênero deve ser M ou F.',
            'city_id.required' => 'O campo Cidade é obrigatório.',
            'city_id.exists' => 'A cidade selecionada é inválida.',
        ];
    }
}
