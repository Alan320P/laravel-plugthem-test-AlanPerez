<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    public function authorize()
    {return true;}

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
            'questions' => 'array',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'in:text,select,rating',
            'questions.*.options' => 'array'
        ];
    }
}
