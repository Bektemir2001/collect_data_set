<?php

namespace App\Http\Controllers\Admin\CollectData\Translate;

use App\Http\Controllers\Controller;
use App\Jobs\CsvImportAndTranslateJob;
use App\Models\Context;
use Illuminate\Http\Request;
use League\Csv\Reader;
use League\Csv\Statement;

class TranslateContextController extends Controller
{
    public function index()
    {
        $contexts = Context::where('lang', '!=', null)->get();
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
                if(in_array('context', $headers) && in_array('question', $headers) && in_array('answers', $headers))
                {
                    CsvImportAndTranslateJob::dispatch(storage_path('app/public/' . $path), $delimiter, auth()->user()->id, $data['source_lang']);
                    return redirect()->route('context.translate.index')->with(['notification' => 'Данные успешно импортированы.']);
                }
                return redirect()->route('context.translate.index')->with(['notification' => 'CSV файл должен содержать поля "context" , "question" и "answers".']);
            } else {
                return redirect()->route('context.translate.index')->with(['notification' => "Не удалось определить разделитель в CSV файле."]);
            }


        } else {
            return redirect()->route('context.translate.index')->with(['notification' => 'Файл не найден.']);
        }
    }

}
