<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    public function authorize()
    {return true;}

    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
            'questions' => 'array',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required_with:questions|string',
            'questions.*.type' => 'in:text,select,rating',
            'questions.*.options' => 'nullable|array',
            'questions.*.delete' => 'boolean'
        ];
    }
}
