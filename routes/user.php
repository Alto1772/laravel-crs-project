<?php

use App\Http\Middleware\CheckAssessmentSessionName;
use App\Http\Middleware\EnsureUserQuestionsAreAllAnswered;
use App\Livewire\Pages\AssessmentResults;
use App\Livewire\Pages\Contact;
use App\Livewire\Pages\InputName;
use App\Livewire\Pages\UserQuestionnaire;
use Illuminate\Support\Facades\Route;

// Main User Routes
Route::view('/colleges', 'pages.colleges')->name('colleges');
Route::view('/about', 'pages.about')->name('about');
Route::get('/contact', Contact::class)->name('contact');

// Route::get('/questionnaires/take-first', [QuestionnaireController::class, 'takeFirst'])->name('questionnaire.take-first');
Route::get('/questionnaires/input-name', InputName::class)->name('questionnaire.input-name');
Route::middleware(CheckAssessmentSessionName::class)->group(function () {
    Route::get('/questionnaires/take/{next?}', UserQuestionnaire::class)->name('questionnaire.take');
    Route::get('/results', AssessmentResults::class)->middleware(EnsureUserQuestionsAreAllAnswered::class)
        ->name('assessment-results');
    Route::get('/user-answers', function () {  // Debug
        return response()->json(session('survey.user-answers'));
    });
});
