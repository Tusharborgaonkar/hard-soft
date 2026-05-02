<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;

Route::get('/', [QuestionnaireController::class, 'index']);


Route::get('/questionnaire', [QuestionnaireController::class , 'index'])->name('questionnaire.index');
Route::post('/questionnaire', [QuestionnaireController::class , 'store'])->name('questionnaire.store');

// Admin Routes
Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class , 'login']);
Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class , 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', function () {
            return redirect('/admin/dashboard');
        }
        );
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class , 'dashboard'])->name('admin.dashboard');

        // Sections CRUD
        Route::get('/sections', [\App\Http\Controllers\Admin\SectionController::class , 'index'])->name('admin.sections.index');
        Route::get('/sections/create', [\App\Http\Controllers\Admin\SectionController::class , 'create'])->name('admin.sections.create');
        Route::post('/sections', [\App\Http\Controllers\Admin\SectionController::class , 'store'])->name('admin.sections.store');
        Route::get('/sections/{id}/edit', [\App\Http\Controllers\Admin\SectionController::class , 'edit'])->name('admin.sections.edit');
        Route::put('/sections/{id}', [\App\Http\Controllers\Admin\SectionController::class , 'update'])->name('admin.sections.update');
        Route::delete('/sections/{id}', [\App\Http\Controllers\Admin\SectionController::class , 'destroy'])->name('admin.sections.destroy');
        Route::post('/sections/reorder', [\App\Http\Controllers\Admin\SectionController::class , 'reorder'])->name('admin.sections.reorder');

        // Questions CRUD
        Route::get('/questions', [\App\Http\Controllers\AdminController::class , 'questions'])->name('admin.questions');
        Route::get('/questions/create', [\App\Http\Controllers\AdminController::class , 'create'])->name('admin.questions.create');
        Route::post('/questions', [\App\Http\Controllers\AdminController::class , 'store'])->name('admin.questions.store');
        Route::get('/questions/{id}/edit', [\App\Http\Controllers\AdminController::class , 'edit'])->name('admin.questions.edit');
        Route::put('/questions/{id}', [\App\Http\Controllers\AdminController::class , 'update'])->name('admin.questions.update');
        Route::delete('/questions/{id}', [\App\Http\Controllers\AdminController::class , 'destroy'])->name('admin.questions.destroy');
        Route::post('/questions/reorder', [\App\Http\Controllers\AdminController::class , 'reorderQuestions'])->name('admin.questions.reorder');
        Route::post('/questions/{id}/toggle', [\App\Http\Controllers\AdminController::class , 'toggleQuestion'])->name('admin.questions.toggle');

        Route::get('/report', [\App\Http\Controllers\AdminController::class , 'report'])->name('admin.report');
        Route::get('/responses', [\App\Http\Controllers\AdminController::class , 'responses'])->name('admin.responses');
        Route::get('/responses/{id}', [\App\Http\Controllers\AdminController::class , 'showResponse'])->name('admin.responses.show');
        Route::get('/responses/{id}/edit', [\App\Http\Controllers\AdminController::class , 'editResponse'])->name('admin.responses.edit');
        Route::put('/responses/{id}', [\App\Http\Controllers\AdminController::class , 'updateResponse'])->name('admin.responses.update');
        Route::delete('/responses/{id}', [\App\Http\Controllers\AdminController::class , 'destroyResponse'])->name('admin.responses.destroy');
    });
