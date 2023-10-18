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
            $answers = "{'text': ['$question->answer']}";
            $csv->insertOne([$question->context, $question->question, $answers]);
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions.csv"',
        ];

        return response($csv->__toString(), 200, $headers);

    }
}
