<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_responses' => Response::count(),
            'total_questions' => Question::count(),
            'active_questions' => Question::where('is_active', true)->count(),
            'recent_responses' => Response::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function questions()
    {
        $questions = Question::with('options')->orderBy('order')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function responses()
    {
        $responses = Response::withCount('answers')->latest()->paginate(20);
        return view('admin.responses.index', compact('responses'));
    }

    public function showResponse($id)
    {
        $response = Response::with(['answers.question'])->findOrFail($id);
        return view('admin.responses.show', compact('response'));
    }

    public function toggleQuestion($id)
    {
        $q = Question::findOrFail($id);
        $q->is_active = !$q->is_active;
        $q->save();

        return back()->with('success', 'Question status updated!');
    }
}
