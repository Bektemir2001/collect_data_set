<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Statement;

class CsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $csvPath;
    protected $user;
    protected $delimiter;

    public function __construct($csvPath, $delimiter, $user)
    {
        $this->csvPath = $csvPath;
        $this->user = $user;
        $this->delimiter = $delimiter;
    }

    public function handle()
    {
        $csv = Reader::createFromPath($this->csvPath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($this->delimiter);
        $statement = (new Statement())
            ->offset(0);
        $results = $statement->process($csv);
        $batchSize = 1000;
        $data = [];

        foreach ($results as $record) {
            if (!isset($record['Title']) || !isset($record['Text'])) {
                continue;
            }
            $data[] = [
                'title' => $record['Title'],
                'context' => $record['Text'],
                'created_by' => $this->user
            ];

            if (count($data) >= $batchSize) {
                DB::table('contexts')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('contexts')->insert($data);
        }
    }

}
