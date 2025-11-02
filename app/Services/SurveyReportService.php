<?php

namespace App\Services;

use App\Models\Survey;
use App\Models\Question;

class SurveyReportService
{
    /**
     * Generar reporte de un survey incluyendo promedios de rating
     */
    public static function generateReport(Survey $survey)
    {
        $report = [];
        $uniqueUsers = [];

        foreach ($survey->questions as $question) {
            $answers = $question->answers()->get();
            $totalAnswers = $answers->count();
            $averageRating = null;

            if ($question->type === 'rating' && $totalAnswers > 0) {
                $ratings = $answers->map(function($a) {
                    return is_numeric($a->answer_text) ? floatval($a->answer_text) : null;
                })->filter();

                if ($ratings->count() > 0) {
                    $averageRating = round($ratings->avg(), 2);
                }
            }

            foreach ($answers as $a) {
                $uniqueUsers[$a->user_id] = true;
            }

            $report[] = [
                'question_id' => $question->id,
                'question_text' => $question->question_text,
                'type' => $question->type,
                'total_answers' => $totalAnswers,
                'average_rating' => $averageRating,
            ];
        }

        return [
            'survey_id' => $survey->id,
            'survey_title' => $survey->title,
            'total_unique_users' => count($uniqueUsers),
            'questions' => $report,
        ];
    }
}
