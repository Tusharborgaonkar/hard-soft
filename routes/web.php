use App\Http\Controllers\QuestionnaireController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire.index');
Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');

// Admin Routes
Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function() { return redirect('/admin/dashboard'); });
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/questions', [\App\Http\Controllers\AdminController::class, 'questions'])->name('admin.questions');
    Route::post('/questions/{id}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleQuestion'])->name('admin.questions.toggle');
    Route::get('/responses', [\App\Http\Controllers\AdminController::class, 'responses'])->name('admin.responses');
    Route::get('/responses/{id}', [\App\Http\Controllers\AdminController::class, 'showResponse'])->name('admin.responses.show');
});
