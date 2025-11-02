<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use App\Services\SurveyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $surveys = Survey::with('questions')->where('status', 'active')->get();
        return $this->successResponse($surveys, 'Listado de encuestas');
    }

    public function store(StoreSurveyRequest $request)
    {
        $survey = SurveyService::createSurvey($request->user(), $request->validated());
        return $this->successResponse($survey, 'Encuesta creada', 201);
    }

    public function show($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        return $this->successResponse($survey);
    }

    public function update(UpdateSurveyRequest $request, $id)
    {
        $survey = Survey::with('questions')->findOrFail($id);

        if ($survey->user_id != $request->user()->id) {
            return $this->errorResponse('No autorizado', 403);
        }

        $survey = SurveyService::updateSurvey($survey, $request->validated());
        return $this->successResponse($survey, 'Encuesta actualizada');
    }

    public function destroy(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        if ($survey->user_id != $request->user()->id) {
            return $this->errorResponse('No autorizado', 403);
        }

        SurveyService::deleteSurvey($survey);
        return $this->successResponse(null, 'Encuesta eliminada');
    }

    public function destroyQuestion(Request $request, $survey_id, $question_id)
    {
        $survey = Survey::findOrFail($survey_id);

        if ($survey->user_id != $request->user()->id) {
            return $this->errorResponse('No autorizado', 403);
        }

        SurveyService::deleteQuestion($survey, $question_id);
        return $this->successResponse(null, 'Pregunta eliminada correctamente');
    }
}
