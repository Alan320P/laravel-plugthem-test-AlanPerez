<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    public function authorize()
    {return true;}

    public function rules()
    {
        return [
            'answer_text' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'answer_text.required' => 'La respuesta es obligatoria',
            'answer_text.string' => 'La respuesta debe ser texto válido'
        ];
    }
}
