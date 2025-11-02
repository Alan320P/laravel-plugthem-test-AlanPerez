<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $surveys = Survey::all();

        foreach ($surveys as $survey) {
            Question::create([
                'survey_id' => $survey->id,
                'question_text' => '¿Cuál es tu color favorito?',
                'type' => 'select',
                'options' => json_encode(['Rojo', 'Azul', 'Verde'])
            ]);

            Question::create([
                'survey_id' => $survey->id,
                'question_text' => 'Califica tu experiencia (1-5)',
                'type' => 'rating',
                'options' => null
            ]);

            Question::create([
                'survey_id' => $survey->id,
                'question_text' => 'Comentario libre',
                'type' => 'text',
                'options' => null
            ]);
        }
    }
}
