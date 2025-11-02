<?php
namespace App\Events;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveyAnswered
{
    use Dispatchable, SerializesModels;

    public $user;
    public $survey;

    public function __construct(User $user, Survey $survey)
    {
        $this->user = $user;
        $this->survey = $survey;
    }
}
