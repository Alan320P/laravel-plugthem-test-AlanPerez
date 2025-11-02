<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Events\SurveyAnswered;
use Illuminate\Support\Facades\Cache;
use App\Services\AnswerStatisticsService; 

class AnswerService
{
    public static function createAnswer($user, Question $question, string $answerText)
    {
        $answer = Answer::create([
            'survey_id' => $question->survey_id,
            'question_id' => $question->id,
            'user_id' => $user->id,
            'answer_text' => $answerText
        ]);

        $survey = Survey::findOrFail($question->survey_id);

        // Disparar el evento con el Survey
        event(new SurveyAnswered($user, $survey));

        // Limpiar cache del reporte del survey ya que cambió
        Cache::forget('survey_report_' . $survey->id);

        return $answer;
    }
    
    public static function getQuestionAnswers(Question $question)
    {
        return $question->answers()->with('user')->get();
    }

    public static function getSurveyAnswers(Survey $survey)
    {
        return Answer::with('user', 'question')
                     ->where('survey_id', $survey->id)
                     ->get();
    }

    /**
     * Generar reporte de un survey con cache Redis usando AnswerStatisticsService
     */
    public static function getSurveyReport(Survey $survey)
    {
        $cacheKey = 'survey_report_' . $survey->id;

        return Cache::remember($cacheKey, 3600, function () use ($survey) {
            $report = [];
            $uniqueUsers = [];

            foreach ($survey->questions as $question) {
                $answers = $question->answers()->get();
                $totalAnswers = $answers->count();

                $averageRating = $question->type === 'rating'
                    ? AnswerStatisticsService::calculateAverageRating($answers)
                    : null;

                $uniqueUsers = array_merge($uniqueUsers, $answers->pluck('user_id')->unique()->toArray());

                $report[] = [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'type' => $question->type,
                    'total_answers' => $totalAnswers,
                    'average_rating' => $averageRating
                ];
            }

            return [
                'survey_id' => $survey->id,
                'survey_title' => $survey->title,
                'total_unique_users' => count(array_unique($uniqueUsers)),
                'questions' => $report
            ];
        });
    }
}
