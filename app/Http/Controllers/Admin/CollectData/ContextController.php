<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Context\StoreRequest;
use App\Models\Context;
use App\Services\GPT3Service;
use Illuminate\Http\Request;
use Laravel\Scout\Scout;

class ContextController extends Controller
{
    protected GPT3Service $GPT3Service;
    public function __construct(GPT3Service $GPT3Service)
    {
        $this->GPT3Service = $GPT3Service;
    }

    public function index()
    {
        $contexts = Context::all();
        return view('admin.context.index', compact('contexts'));
    }

    public function create()
    {
        return view('admin.context.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $context = Context::create($data);
        return redirect()->route('context.show', $context->id);
    }

    public function generateQuestionAndAnswer(Context $context)
    {
        dd($this->GPT3Service->generateQuestionAndAnswer($context->context));
    }

    public function show(Context $context)
    {
        $context_text = html_entity_decode(strip_tags($context->context));
        $context_text = str_replace(array("\n", "\t", "\r", "\u{A0}"), '', $context_text);
        return view('admin.context.show', compact('context', 'context_text'));
    }
}
