<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Jobs\UploadMistralJob;
use App\Services\CsvService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected CsvService $csvService;

    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
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
}
