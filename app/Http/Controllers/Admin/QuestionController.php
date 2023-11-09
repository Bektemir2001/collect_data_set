<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Jobs\UploadMistralJob;
use App\Repositories\Admin\Collect_data\QuestionRepository;
use App\Services\CsvService;
use Illuminate\Http\Request;
use League\Csv\Writer;

class QuestionController extends Controller
{
    protected CsvService $csvService;
    protected QuestionRepository $questionRepository;

    public function __construct(CsvService $csvService, QuestionRepository $questionRepository)
    {
        $this->csvService = $csvService;
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        return view('admin.question.index');
    }

    public function uploadCsv(QuestionRequest $request)
    {
        $data = $request->validated();
        $csv_result = $this->csvService->defineDelimiterAndGetFile($data['csv_file']);

        $delimiter = $csv_result[0];
        $csv_file = $csv_result[1];
        $validate_file = $this->csvService->checkCsvFile($csv_file, $delimiter, ['instruction', 'output']);
        if(!$validate_file)
        {
            return back()->with(['notification' => 'required fields ["instruction", "output"]']);
        }
        UploadMistralJob::dispatch($csv_file, $delimiter, auth()->user()->id, $data['source_lang']);

        return back()->with(['notification' => 'success']);
    }

    public function export(Request $request)
    {
        $data = $request->validate(['types' => 'required']);
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setDelimiter(';');
        $csv->insertOne(['input', 'output']);
        $questions = $this->questionRepository->getQuestionsForMistral($data['types']);
        foreach ($questions as $question)
        {
            $instruction = $question->question;
            $output = $question->answer;
            $csv->insertOne([$instruction, $output]);
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_for_mistral.csv"',
        ];
        return response($csv->__toString(), 200, $headers);
    }


}
