<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\Collect_data\QuestionRepository;
use App\Services\NewTextService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FailedContentsController extends Controller
{
    protected NewTextService $textService;
    protected QuestionRepository $questionRepository;
    public function __construct(NewTextService $textService, QuestionRepository $questionRepository)
    {
        $this->textService = $textService;
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        $context = DB::table('failed_contexts')->first();
        return view('admin.failed_context', compact('context'));
    }

    public function saveQuestionAndDeleteFailedContext(Request $request)
    {
        $data = $request->validate(
            [
                'context_id' => 'required',
                'failed_context_id' => 'required',
                'text' => 'required'
            ]
        );

        $questions = $this->textService->forGpt4($data['text']);
        $user = auth()->user()->id;
        $this->questionRepository->saveQuestions($questions['data'], $data['context_id'], $user, 'gpt-4');
        DB::table('failed_contexts')->where('id', '=', $data['failed_context_id'])->delete();
        return back();

    }
    public function justDelete($failed_context_id)
    {
        DB::table('failed_contexts')->where('id', '=', $failed_context_id)->delete();
        return back();
    }
}
