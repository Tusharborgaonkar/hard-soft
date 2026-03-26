<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $sections = Question::where('is_active', true)
            ->with('options')
            ->get()
            ->groupBy('section_title_gu');

        return view('gujarati_form', compact('sections'));
    }
}
