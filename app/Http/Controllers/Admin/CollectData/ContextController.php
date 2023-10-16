<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Context\StoreRequest;
use App\Http\Requests\Admin\Context\UpdateRequest;
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
        $contexts = Context::paginate(100);
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

    public function update(UpdateRequest $request, Context $context)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $context->update($data);
        return redirect()->route('context.show', $context->id)->with(['notification' => 'context successfully updated']);
    }

    public function show(Context $context)
    {
        $context_text = html_entity_decode(strip_tags($context->context));
        $context_text = str_replace(array("\n", "\t", "\r", "\u{A0}", '"', "'"), '', $context_text);
        $next_context = Context::where('id', '>', $context->id)->min('id');
        $previous_context = Context::where('id', '<', $context->id)->max('id');
        return view('admin.context.show', compact('context', 'context_text', 'next_context', 'previous_context'));
    }
}
