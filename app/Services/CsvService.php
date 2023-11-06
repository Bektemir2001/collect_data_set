<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvService
{
    public function defineDelimiterAndGetFile(UploadedFile $file): array
    {
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

    public function checkCsvFile(string $csvFile, string $delimiter, array $parameters): bool
    {
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($delimiter);
        $statement = (new Statement())
            ->offset(0)
            ->limit(10);
        $results = $statement->process($csv);
        $headers = $results->getHeader();
        $diff = array_diff($parameters, $headers);
        if(empty($diff))
        {
            return true;
        }
        return false;
    }
}
