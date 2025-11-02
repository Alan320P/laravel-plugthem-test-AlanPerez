<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use App\Services\AnswerService;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        $questions = Question::all();
        $users = User::all();

        foreach ($questions as $question) {
            foreach ($users as $user) {
                $answerText = match ($question->type) {
                    'select' => ['Rojo', 'Azul', 'Verde'][rand(0,2)],
                    'rating' => rand(1,5),
                    'text' => 'Comentario de ' . $user->name,
                };

                AnswerService::createAnswer($user, $question, $answerText);
            }
        }
    }
}
