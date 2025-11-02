<?php

namespace App\Services;

use App\Models\Survey;

class SurveyService
{
    public static function createSurvey($user, array $data)
    {
        $survey = Survey::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'active',
            'user_id' => $user->id,
        ]);

        if (!empty($data['questions'])) {
            foreach ($data['questions'] as $q) {
                $survey->questions()->create([
                    'question_text' => $q['question_text'],
                    'type' => $q['type'] ?? 'text',
                    'options' => isset($q['options']) ? json_encode($q['options']) : null
                ]);
            }
        }

        return $survey->load('questions');
    }

    public static function updateSurvey($survey, array $data)
    {
        $survey->update($data);

        if (!empty($data['questions'])) {
            foreach ($data['questions'] as $qData) {
                if (!empty($qData['delete']) && !empty($qData['id'])) {
                    $survey->questions()->where('id', $qData['id'])->delete();
                    continue;
                }
                if (!empty($qData['id'])) {
                    $question = $survey->questions()->find($qData['id']);
                    if ($question) {
                        $question->update([
                            'question_text' => $qData['question_text'],
                            'type' => $qData['type'] ?? $question->type,
                            'options' => isset($qData['options']) ? json_encode($qData['options']) : $question->options
                        ]);
                    }
                } else {
                    $survey->questions()->create([
                        'question_text' => $qData['question_text'],
                        'type' => $qData['type'] ?? 'text',
                        'options' => isset($qData['options']) ? json_encode($qData['options']) : null
                    ]);
                }
            }
        }

        return $survey->load('questions');
    }

    public static function deleteSurvey($survey)
    {
        $survey->delete();
        return true;
    }

    public static function deleteQuestion($survey, $question_id)
    {
        $question = $survey->questions()->findOrFail($question_id);
        $question->delete();
        return true;
    }
}
