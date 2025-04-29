<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser um texto.',
            'name.max' => 'O campo Nome não pode ter mais que 255 caracteres.',

            'state.required' => 'O campo Estado é obrigatório.',
            'state.string' => 'O campo Estado deve ser um texto.',
            'state.size' => 'O campo Estado deve ter exatamente 2 caracteres (ex: SP, RJ).',
        ];
    }
}
