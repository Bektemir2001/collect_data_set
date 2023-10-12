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
        $text = $data['context'];
        $text = str_replace(array("\n", "\t"), '', $text);
        Scout::initialize();
        Scout::createIndexForModel(Context::class);
        $question = new Context();
        $question->context = $data['context'];
        $question->title = $data['title'];
        $question->save();
        dd(strlen($text), strlen($data['context']));
//        $questions = $this->GPT3Service->generateQuestionAndAnswer($data['context'], 10);
    }

    public function generateQuestionAndAnswer(Context $context)
    {
        dd($this->GPT3Service->generateQuestionAndAnswer($context->context, 5));
    }
}
