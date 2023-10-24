<?php

namespace App\Jobs;

use App\Models\Context;
use App\Models\QuestionAnswer;
use App\Services\TranslateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use League\Csv\Statement;

class IndexingJob implements ShouldQueue
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

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $csv = Reader::createFromPath($this->csvPath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($this->delimiter);
        $statement = (new Statement())
            ->offset(0)
            ->limit(10000);
        $results = $statement->process($csv);
        foreach ($results as $record) {

            $jsonString = str_replace("'", "\"", $record['answers']);
            $answers = json_decode($jsonString);
            if(!isset($answers->text) && !isset($answers->answer_start)) continue;
            $start_index = $answers->answer_start;
            $answers = $answers->text;

            for($j = 0; $j < count($answers); $j++)
            {
                if($answers[$j] == null && $start_index[$j] == null) continue;
                $question = QuestionAnswer::where('original_question', $record['question'])->first();
                if(!$question) continue;
                $question->start_index = $start_index[$j];
                $question->save();
            }
        }
    }
}
