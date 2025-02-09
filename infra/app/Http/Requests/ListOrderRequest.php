<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListOrderRequest extends FormRequest
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
            'departure_date_ini' => ['nullable', 'date_format:Y-m-d'],
            'departure_date_end' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:departure_date_ini'],
            'return_date_ini' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:departure_date_ini'],
            'return_date_end' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:return_date_ini'],
            'destiny' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
        ];
    }


    public function messages(): array
    {
        return [
            // Mensagens para departure_date_ini
            'departure_date_ini.date_format' => 'A data de saída inicial deve estar no formato dd/mm/yyyy.',

            // Mensagens para departure_date_end
            'departure_date_end.date_format' => 'A data de saída final deve estar no formato dd/mm/yyyy.',
            'departure_date_end.after_or_equal' => 'A data de saída final deve ser igual ou posterior à data de saída inicial.',

            // Mensagens para return_date_ini
            'return_date_ini.date_format' => 'A data de retorno inicial deve estar no formato dd/mm/yyyy.',
            'return_date_ini.after_or_equal' => 'A data de retorno inicial deve ser igual ou posterior à data de saída inicial.',

            // Mensagens para return_date_end
            'return_date_end.date_format' => 'A data de retorno final deve estar no formato dd/mm/yyyy.',
            'return_date_end.after_or_equal' => 'A data de retorno final deve ser igual ou posterior à data de retorno inicial.',

            // Mensagens para destiny
            'destiny.string' => 'O destino deve ser um texto válido.',
            'destiny.max' => 'O destino não pode ter mais de 255 caracteres.',

            // Mensagens para user_id
            'user_id.uuid' => 'O identificador do usuário deve ser um UUID válido.',
            'user_id.exists' => 'O usuário especificado não foi encontrado no sistema.'
        ];
    }


}
