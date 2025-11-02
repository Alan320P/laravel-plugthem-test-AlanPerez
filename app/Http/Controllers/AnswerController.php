<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Models\Question;
use App\Models\Survey;
use App\Services\AnswerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class AnswerController extends Controller
{
    use ApiResponseTrait;
    public function store(StoreAnswerRequest $request, $question_id)
    {
        try {
            $question = Question::with('survey')->findOrFail($question_id);

            $answer = AnswerService::createAnswer(
                $request->user(),
                $question,
                $request->validated()['answer_text']
            );

            return $this->successResponse($answer, 'Respuesta creada correctamente', 201);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pregunta no encontrada', 404);

        } catch (ValidationException $e) {
            return $this->errorResponse('Validación fallida', 422, $e->errors());

        } catch (Exception $e) {
            return $this->errorResponse('Error inesperado', 500);
        }
    }

    public function index($question_id)
    {
        try {
            $question = Question::with('answers.user')->findOrFail($question_id);

            $answers = AnswerService::getQuestionAnswers($question);

            return $this->successResponse($answers, 'Listado de respuestas de la pregunta');

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pregunta no encontrada', 404);

        } catch (Exception $e) {
            return $this->errorResponse('Error inesperado', 500);
        }
    }

    public function surveyAnswers($survey_id)
    {
        try {
            $survey = Survey::findOrFail($survey_id);

            $answers = AnswerService::getSurveyAnswers($survey);

            return $this->successResponse($answers, 'Listado de respuestas del survey');

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Encuesta no encontrada', 404);

        } catch (Exception $e) {
            return $this->errorResponse('Error inesperado', 500);
        }
    }

    public function surveyReport($survey_id)
    {
        try {
            $survey = Survey::with('questions.answers')->findOrFail($survey_id);

            $report = AnswerService::getSurveyReport($survey);

            return $this->successResponse($report, 'Reporte generado exitosamente');

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Encuesta no encontrada', 404);

        } catch (Exception $e) {
            return $this->errorResponse('Error inesperado', 500);
        }
    }
}
