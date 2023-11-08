<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Services\Gpt4Service;
use App\Services\TextService;
use Illuminate\Http\Request;

class Gpt4Controller extends Controller
{
    protected TextService $textService;
    protected Gpt4Service $gpt4Service;

    public function __construct(TextService $textService, Gpt4Service $gpt4Service)
    {

        $this->textService = $textService;
        $this->gpt4Service = $gpt4Service;
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
        dd($this->gpt4Service->generateQuestion($text));
    }
}
