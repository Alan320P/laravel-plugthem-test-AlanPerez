<?php

namespace App\Services;

use Illuminate\Support\Collection;

class AnswerStatisticsService
{
    /**
     * Calcular promedio de respuestas tipo rating
     *
     * @param Collection $answers
     * @return float|null
     */
    public static function calculateAverageRating(Collection $answers): ?float
    {
        $ratings = $answers->map(function($answer) {
            return is_numeric($answer->answer_text) ? floatval($answer->answer_text) : null;
        })->filter();

        if ($ratings->count() === 0) {
            return null;
        }

        return round($ratings->avg(), 2);
    }

    /**
     * Contar usuarios únicos en un conjunto de respuestas
     *
     * @param Collection $answers
     * @return int
     */
    public static function countUniqueUsers(Collection $answers): int
    {
        return $answers->pluck('user_id')->unique()->count();
    }
}
