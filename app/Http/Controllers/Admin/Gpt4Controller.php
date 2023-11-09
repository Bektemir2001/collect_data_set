<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Gpt4Job;
use App\Models\Context;
use App\Repositories\Admin\Collect_data\QuestionRepository;
use App\Services\Gpt4Service;
use App\Services\TextService;
use Illuminate\Http\Request;

class Gpt4Controller extends Controller
{
    protected TextService $textService;
    protected Gpt4Service $gpt4Service;
    protected QuestionRepository $questionRepository;

    public function __construct(TextService $textService, Gpt4Service $gpt4Service, QuestionRepository $questionRepository)
    {

        $this->textService = $textService;
        $this->gpt4Service = $gpt4Service;
        $this->questionRepository = $questionRepository;
    }

    public function generateQuestion(Request $request)
    {
        $data = $request->validate([
            'context_id' => 'required'
        ]);
        $context = Context::where('id', $data['context_id'])->first();
        $text = $this->textService->cleanText($context->context);
        $title = $context->title;
        $text = $title . "\n".$text;
        $gpt_result = $this->gpt4Service->generateQuestion($text);

        if($gpt_result['status_code'] == 500)
        {
            return response(['data' => $gpt_result['data'], 'status_code' => $gpt_result['status_code']])->setStatusCode(500);
        }
        $gpt_result = $this->textService->forGpt4($gpt_result['data']);
        if($gpt_result['status_code'] == 500)
        {
            return response(['data' => $gpt_result['data'], 'status_code' => $gpt_result['status_code']])->setStatusCode(500);
        }
        $this->questionRepository->saveQuestions($gpt_result['data'], $context->id, auth()->user()->id, 'gpt-4');
        return response(['data' => 'success', 'status_code' => 200]);

    }

    public function defaultGenerating(Request $request)
    {
        $data = $request->validate([
            'context_start' => 'required|integer',
            'context_end' => 'required|integer'
        ]);
        $user = auth()->user()->id;
        Gpt4Job::dispatch($this->gpt4Service, $this->textService, $this->questionRepository, $user, $data['context_start'], $data['context_end']);
        return back()->with(['notification' => 'success']);
    }
}
