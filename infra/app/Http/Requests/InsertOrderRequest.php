<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|string',
            'destiny' => 'required|string',
            'departure_date' => 'required|string',
            'return_date' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Usuario é obrigatório',
            'destiny.required' => 'Destino é obrigatório',
            'departure_date.required' => 'Data de partida é obrigatório',
            'return_date.required' => 'Data de retorno é obrigatório',
        ];
    }
}
