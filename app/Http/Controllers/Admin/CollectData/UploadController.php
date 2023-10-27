<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Jobs\CsvImportJob;
use App\Jobs\ImportAlpacaKGJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class UploadController extends Controller
{
    public function CSV(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $data = $this->getSeparatorAndFile($request);
            $selectedSeparator = $data[0];
            $csvFile = $data[1];
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
                if(in_array('Text', $headers) && in_array('Title', $headers))
                {
                    CsvImportJob::dispatch($csvFile, $delimiter, auth()->user()->id);
                    return redirect()->route('context.index')->with(['notification' => 'Данные успешно импортированы.']);
                }
                return redirect()->route('context.index')->with(['notification' => 'CSV файл должен содержать поля "Title" и "Text".']);
            } else {
                return redirect()->route('context.index')->with(['notification' => "Не удалось определить разделитель в CSV файле."]);
            }


        } else {
            return redirect()->route('context.index')->with(['notification' => 'Файл не найден.']);
        }
    }

    public function csvQuestions(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $data = $this->getSeparatorAndFile($request);
            $selectedSeparator = $data[0];
            $csvFile = $data[1];
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
                if(in_array('Text', $headers) && in_array('Title', $headers))
                {
                    CsvImportJob::dispatch($csvFile, $delimiter, auth()->user()->id);
                    return redirect()->route('context.index')->with(['notification' => 'Данные успешно импортированы.']);
                }
                return redirect()->route('context.index')->with(['notification' => 'CSV файл должен содержать поля "Title" и "Text".']);
            } else {
                return redirect()->route('context.index')->with(['notification' => "Не удалось определить разделитель в CSV файле."]);
            }


        } else {
            return redirect()->route('context.index')->with(['notification' => 'Файл не найден.']);
        }
    }

    public function alpacaKG(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $data = $this->getSeparatorAndFile($request);
            $selectedSeparator = $data[0];
            $csvFile = $data[1];
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
                if(in_array('instruction_KG', $headers) && in_array('input_KG', $headers))
                {
                    ImportAlpacaKGJob::dispatch($csvFile, $delimiter, auth()->user()->id);
                    return redirect()->route('context.index')->with(['notification' => 'Данные успешно импортированы.']);
                }
                return redirect()->route('context.index')->with(['notification' => 'CSV файл должен содержать поля "Title" и "Text".']);
            } else {
                return redirect()->route('context.index')->with(['notification' => "Не удалось определить разделитель в CSV файле."]);
            }


        } else {
            return redirect()->route('context.index')->with(['notification' => 'Файл не найден.']);
        }

    }

    public function getSeparatorAndFile(Request $request){
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

        return [$selectedSeparator, $csvFile];
    }
}
