<?php

use App\Livewire\Pages\CollegeForm;
use App\Livewire\Pages\CollegeTable;
use App\Livewire\Pages\KNNDashboard;
use App\Livewire\Pages\QuestionnaireList;
use App\Livewire\Pages\QuestionnaireView;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware(['auth'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/colleges', CollegeTable::class)->name('colleges');
    Route::get('/colleges/create', CollegeForm::class)->name('colleges.create');
    Route::get('/colleges/{college}/edit', CollegeForm::class)->name('colleges.edit');
    Route::get('/questionnaires', QuestionnaireList::class)->name('questionnaires');
    Route::get('/questionnaires/{questionnaire}', QuestionnaireView::class)->name('questionnaires.show');
    Route::get('/knn', KNNDashboard::class)->name('knn');
    Route::view('/privacy', 'pages.privacy')->name('privacy');
});
