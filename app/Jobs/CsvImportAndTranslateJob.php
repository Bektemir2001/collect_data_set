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
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvImportAndTranslateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $csvPath;
    protected $user;
    protected $delimiter;
    protected $source_lang;
    protected $target_lang;

    public function __construct($csvPath, $delimiter, $user, $source_lang)
    {
        $this->csvPath = $csvPath;
        $this->user = $user;
        $this->delimiter = $delimiter;
        $this->source_lang = $source_lang;
        $this->target_lang = 'KG';
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
        $i = 0;
        $last_context = '';
        $translator = new TranslateService();
        $context = null;
        foreach ($results as $record) {
            if (!isset($record['context']) || !isset($record['question']) || !isset($record['answer'])) {
                continue;
            }
            if($record['context'] != $last_context || $context == null){
                $title = null;
                $original_title = null;
                if(isset($record['title'])){
                    $title = $translator->translate($record['title'], $this->source_lang, $this->target_lang)['result'];
                    $original_title = $record['title'];
                }
                $translated_context = $record['context'];
                $context = Context::create([
                    'title' => $title,
                    'context' => $translated_context,
                    'original_title' => $original_title,
                    'original_context' => $record['context'],
                    'created_by' => $this->user,
                    'lang' => $this->source_lang
                ]);
                $last_context = $record['context'];
            }

            $question = $translator->translate($record['question'], $this->source_lang, $this->target_lang)['result'];
            $answer = $translator->translate($record['answer'], $this->source_lang, $this->target_lang)['result'];

//            $jsonString = str_replace("'", "\"", $record['answers']);
//            $answers = json_decode($jsonString);
//            if(!isset($answers->text)) continue;
//            $answers = $answers->text;
//            for($j = 0; $j < count($answers); $j++)
//            {
//                $answer = $translator->translate($answers[$j], $this->source_lang, $this->target_lang)['result'];
                if($answer == null) continue;
                QuestionAnswer::create(
                    [
                        'context_id' => $context->id,
                        'question' => $question,
                        'answer' => $answer,
                        'original_question' => $record['question'],
                        'original_answer' => $record['answer'],
                        'created_by' => $this->user,
                        'lang' => $this->source_lang,
                        'type' => "orca"
                    ]
                );
//            }
            if($i % 10 == 0){
                sleep(1);
            }
            $i += 1;
        }
    }
}
