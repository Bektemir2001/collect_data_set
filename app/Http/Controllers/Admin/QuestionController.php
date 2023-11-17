<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Http\Requests\QuestionStoreRequest;
use App\Jobs\UploadMistralJob;
use App\Models\Context;
use App\Models\QuestionAnswer;
use App\Repositories\Admin\Collect_data\QuestionRepository;
use App\Services\CsvService;
use App\Services\NewTextService;
use App\Services\TextService;
use Illuminate\Http\Request;
use League\Csv\Writer;

class QuestionController extends Controller
{
    protected CsvService $csvService;
    protected QuestionRepository $questionRepository;
    protected TextService $textService;
    protected NewTextService $newTextService;

    public function __construct(CsvService $csvService, QuestionRepository $questionRepository,
                                TextService $textService, NewTextService $newTextService)
    {
        $this->csvService = $csvService;
        $this->questionRepository = $questionRepository;
        $this->textService = $textService;
        $this->newTextService = $newTextService;
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

    public function create()
    {
        return view('question.create');
    }
    public function edit(QuestionAnswer $questionAnswer)
    {
        return view('question.edit', compact('questionAnswer'));
    }

    public function store(QuestionStoreRequest $request)
    {
        $data = $request->validated();

        $result = $this->questionRepository->store($data, auth()->user()->id, 'manual');
        return back()->with(['notification' => $result['data']]);
    }

    public function saveGeneratedQuestions(Request $request, Context $context)
    {
        $data = $request->validate(['generated_questions' => 'required']);
        $result = $this->newTextService->forGpt4($data['generated_questions']);
        if($result['status_code'] == 500)
        {
            dd($result['data']);
        }
        $this->questionRepository->saveQuestions($result['data'], $context->id, auth()->user()->id, 'manual');
        return back()->with(['notification' => 'success']);
    }

}
