<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities')->where(function ($query) {
                    return $query->where('state', $this->state);
                }),
            ],
            'state' => ['required', 'string', 'size:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser um texto.',
            'name.max' => 'O campo Nome não pode ter mais que 255 caracteres.',
            'name.unique' => 'Já existe uma cidade com este nome para o estado informado.',

            'state.required' => 'O campo Estado é obrigatório.',
            'state.string' => 'O campo Estado deve ser um texto.',
            'state.size' => 'O campo Estado deve ter exatamente 2 caracteres (ex: SP, RJ).',
        ];
    }
}
