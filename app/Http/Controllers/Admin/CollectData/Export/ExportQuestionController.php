<?php

namespace App\Http\Controllers\Admin\CollectData\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Export\ExportQuestionRequest;
use App\Repositories\Admin\Collect_data\QuestionRepository;
use Illuminate\Http\Request;
use League\Csv\Writer;

class ExportQuestionController extends Controller
{

    protected QuestionRepository $questionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function csv(ExportQuestionRequest $request)
    {
        $data = $request->validated();
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['context', 'question', 'answers']);
        $questions = $this->questionRepository->getQuestionsForCsv($data['limit']);

        foreach ($questions as $question)
        {
            $answers = str_replace("'", "", $question->answer);
            $answers = "{'text': ['$answers'], 'answer_start': [$question->start_index]}";
            $csv->insertOne([$question->context, $question->question, $answers]);
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions.csv"',
        ];

        return response($csv->__toString(), 200, $headers);

    }

    public function forLama(ExportQuestionRequest $request)
    {
        $data = $request->validated();
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Instruction', 'Input', 'Output']);
        $questions = $this->questionRepository->getQuestionsForLlama($data['limit']);

        foreach ($questions as $question)
        {
            $instruction = $question->question;
            $output = $question->answer;
            if($question->lang != null)
            {
                $input = $question->context;
            }
            else{
                $input = $question->title;
            }

            if($input == null) $input = '';
            $csv->insertOne([$instruction, $input, $output]);
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_for_lama.csv"',
        ];
        return response($csv->__toString(), 200, $headers);
    }
}
