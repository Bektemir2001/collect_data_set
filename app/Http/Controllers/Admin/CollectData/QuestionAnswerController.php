<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\QuestionAnswer;
use App\Services\GPT3Service;
use Exception;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    protected GPT3Service $GPT3Service;

    public function __construct(GPT3Service $GPT3Service)
    {
        $this->GPT3Service = $GPT3Service;
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required',
            'answer' => 'required',
            'question' => 'required'
        ]);
        try{
            QuestionAnswer::where('id', $data['question_id'])->update([
                'answer' => $data['answer'],
                'question' => $data['question'],
                'updated_by' => auth()->user()->id]);
            return response(['data' => 'question successfully updated']);
        }
        catch (Exception $e)
        {
            return response(['data' => $e->getMessage(), 'code' => 500]);
        }

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'context_id' => 'required',
            'answer' => 'required',
            'question' => 'required'
         ]);

        $data['created_by'] = auth()->user()->id;
        $data['type'] = 'manual';

        $question = QuestionAnswer::create($data);

        return response(['data' => $question]);
    }
    public function autoGenerate(Request $request)
    {
        $text = $request->text;
        $context_id = $request->context_id;
        $questions = $this->GPT3Service->generateQuestionAndAnswer($text);
        $result = [];
        foreach ($questions as $item)
        {
            $q = explode(':', $item['question']);
            $a = explode(':', $item['answer']);
            $question = QuestionAnswer::create([
                'context_id' => $context_id,
                'question' => $q[count($q)-1],
                'answer' => $a[count($a)-1],
                'type' => 'gpt-3',
                'created_by' => auth()->user()->id
                ]);
            array_push($result, $question);
        }
        return response(['data' => $result]);
    }

    public function remove(Request $request)
    {
        try{
            $data = $request->validate(['question_id' => 'required']);
            QuestionAnswer::where('id', $data['question_id'])->delete();
            return response(['data' => 'success', 'code'=>200]);
        }
        catch (Exception $e)
        {
            return response(['data' => $e->getMessage(), 'code' => 500]);
        }

    }
}
