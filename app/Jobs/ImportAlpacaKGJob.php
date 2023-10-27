<?php

namespace App\Jobs;

use App\Models\Context;
use App\Models\QuestionAnswer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportAlpacaKGJob implements ShouldQueue
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

    public function handle(): void
    {
        $csv = Reader::createFromPath($this->csvPath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($this->delimiter);
        $statement = (new Statement())
            ->offset(0)
            ->limit(10000);
        $results = $statement->process($csv);
        $last_title = '';
        $context = null;
        foreach ($results as $record) {
            if (!isset($record['instruction_KG']) || !isset($record['input_KG']) || !isset($record['output_KG'])) {
                continue;
            }
            if($record['input_KG'] != $last_title || $context == null){
                $context = Context::create([
                    'title' => $record['input_KG'],
                ]);
                $last_title = $record['input_KG'];
            }
            QuestionAnswer::create(
                [
                    'context_id' => $context->id,
                    'question' => $record['instruction_KG'],
                    'answer' => $record['output_KG'],
                    'created_by' => $this->user,
                ]
            );
        }
    }
}
