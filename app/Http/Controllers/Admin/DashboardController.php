<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $questions = DB::table('question_answers')
            ->select(DB::raw('COUNT(id) as question_count'), 'type')
            ->groupBy('type')
            ->get();
        $total_count = 0;
        foreach ($questions as $question)
        {
            $total_count += $question->question_count;
        }
        return view('admin.dashboard', compact('questions', 'total_count'));
    }
}
