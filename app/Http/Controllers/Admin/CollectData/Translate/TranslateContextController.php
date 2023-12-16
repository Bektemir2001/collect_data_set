<?php

namespace App\Http\Controllers\Admin\CollectData\Translate;

use App\Http\Controllers\Controller;
use App\Jobs\CsvImportAndTranslateJob;
use App\Models\Context;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class TranslateContextController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobs')->get();
        foreach ($jobs as $job)
        {
            $payload = json_decode($job->payload);
            if($payload->displayName == "App\\Jobs\\CsvImportAndTranslateJob")
            {
                \session()->flash('notification', 'Данные успешно импортируется.');
                break;
            }
        }
        $contexts = Context::where('lang', '!=', null)->paginate(100);
        return view('admin.context.translate.index', compact('contexts'));
    }

    public function uploadCSV(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $data = $request->validate(['source_lang' => 'required']);
            $file = $request->file('csv_file');
            $path = $file->store('data', 'public');
            $csvFile = storage_path('app/public/' . $path);
            $fileContent = file_get_contents($csvFile);
            $possibleSeparators = [',', ';', '\t', '|'];

            $selectedSeparator = null;

            foreach ($possibleSeparators as $separator) {
                if (strpos($fileContent, $separator) !== false) {
                    $selectedSeparator = $separator;
                    break;
                }
            }
            if ($selectedSeparator) {
                $delimiter = $selectedSeparator;
                $csv = Reader::createFromPath($csvFile, 'r');
                $csv->setHeaderOffset(0);
                $csv->setDelimiter($delimiter);
                $statement = (new Statement())
                    ->offset(0)
                    ->limit(10);
                $results = $statement->process($csv);
                $headers = $results->getHeader();
                if(in_array('context', $headers) && in_array('question', $headers) && in_array('answer', $headers))
                {
                    CsvImportAndTranslateJob::dispatch(storage_path('app/public/' . $path), $delimiter, auth()->user()->id, $data['source_lang']);
                    return redirect()->route('context.translate.index')->with(['notification' => 'Данные успешно импортируется.']);
                }
                return redirect()->route('context.translate.index')->with(['notification' => 'CSV файл должен содержать поля "context" , "question" и "answer".']);
            } else {
                return redirect()->route('context.translate.index')->with(['notification' => "Не удалось определить разделитель в CSV файле."]);
            }


        } else {
            return redirect()->route('context.translate.index')->with(['notification' => 'Файл не найден.']);
        }
    }

    public function show(Context $context)
    {
        $context_text = html_entity_decode(strip_tags($context->context));
        $context_text = str_replace(array("\n", "\t", "\r", "\u{A0}", '"', "'"), '', $context_text);
        $next_context = Context::where('id', '>', $context->id)
            ->where('lang', '!=', null)
            ->min('id');
        $previous_context = Context::where('id', '<', $context->id)
            ->where('lang', '!=', null)
            ->max('id');
        return view('admin.context.translate.show', compact('context', 'context_text', 'next_context', 'previous_context'));
    }
}
