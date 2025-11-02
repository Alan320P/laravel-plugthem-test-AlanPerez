<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AnswerController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/surveys', [SurveyController::class, 'index']);
    Route::post('/surveys', [SurveyController::class, 'store']);
    Route::get('/surveys/{id}', [SurveyController::class, 'show']);
    Route::put('/surveys/{id}', [SurveyController::class, 'update']);
    Route::delete('/surveys/{id}', [SurveyController::class, 'destroy']);

    Route::delete('/surveys/{survey}/questions/{question}', [SurveyController::class, 'destroyQuestion']);

    Route::post('/questions/{question_id}/answers', [AnswerController::class, 'store']);
    Route::get('/questions/{question_id}/answers', [AnswerController::class, 'index']);
    Route::get('/surveys/{survey_id}/answers', [AnswerController::class, 'surveyAnswers']);

    Route::get('/reports/survey/{survey_id}', [AnswerController::class, 'surveyReport']);
});
