use App\Http\Controllers\QuestionnaireController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/questionnaire', [QuestionnaireController::class, 'index']);
