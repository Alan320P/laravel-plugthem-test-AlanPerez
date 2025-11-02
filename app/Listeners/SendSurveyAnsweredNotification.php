<?php

namespace App\Listeners;

use App\Events\SurveyAnswered;
use Illuminate\Support\Facades\Log;

class SendSurveyAnsweredNotification
{
    /**
     * Manejar el evento.
     */
    public function handle(SurveyAnswered $event)
    {
        $userId = $event->user->id;
        $surveyId = $event->survey->id;
        $date = now()->toDateTimeString();

        Log::info("Usuario {$userId} respondió la encuesta {$surveyId} el {$date}");
    }
}
