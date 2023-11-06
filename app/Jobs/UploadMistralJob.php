<?php

namespace App\Jobs;

use App\Models\Context;
use App\Models\QuestionAnswer;
use App\Services\Question\UploadCsvService;
use App\Services\Question\UploadKGCsvService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use League\Csv\Statement;

class UploadMistralJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $delimiter;
    protected $csv_file;
    protected $lang;
    /**
     * Create a new job instance.
     */
    public function __construct($csv_file, $delimiter, $user, $lang)
    {
        $this->csv_file = $csv_file;
        $this->delimiter = $delimiter;
        $this->user = $user;
        $this->lang = $lang;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $csv = Reader::createFromPath($this->csv_file, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($this->delimiter);
        $statement = (new Statement())
            ->offset(0)
            ->limit(20000);
        $results = $statement->process($csv);

        if($this->lang != 'KG')
        {
            $uploader = new UploadCsvService();
            $uploader->upload($results, $this->user, $this->lang, $this->csv_file);
        }

    }
}
