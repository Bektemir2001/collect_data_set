<?php

namespace App\Jobs;

use App\Models\Context;
use App\Models\FailedContexts;
use App\Models\UploadProcess;
use App\Repositories\Admin\Collect_data\QuestionRepository;
use App\Services\Gpt4Service;
use App\Services\TextService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Gpt4Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected int $user;
    protected int $context_start;
    protected int $context_stop;
    protected TextService $textService;
    protected Gpt4Service $gpt4Service;
    protected QuestionRepository $questionRepository;
    public function __construct(Gpt4Service $gpt4Service, TextService $textService, QuestionRepository $questionRepository,
    int $user, int $context_start, int $context_stop)
    {
        $this->textService = $textService;
        $this->gpt4Service = $gpt4Service;
        $this->questionRepository = $questionRepository;
        $this->user = $user;
        $this->context_start = $context_start;
        $this->context_stop = $context_stop;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $process = UploadProcess::create([
            'model' => 'Gpt 4',
            'description' => 'Generating questions and answers',
            'present' => 0
        ]);
        $total = $this->context_stop - $this->context_start;
        $j = 0;
        for($i = $this->context_start; $i <= $this->context_stop; $i++)
        {
            $j += 1;
            if($i % 20 == 0)
            {
                $process->update(['present' => round(($j / $total) * 100, 2)]);
                sleep(40);
            }
            $context = Context::where('id', $i)->first();
            if(!$context) continue;
            $text = $this->textService->cleanText($context->context);
            if(strlen($text) < 5000) continue;
            $title = $context->title;
            $text = $title . "\n".$text;
            $gpt_result = $this->gpt4Service->generateQuestion($text);
            if($gpt_result['status_code'] == 500)
            {
                FailedContexts::create([
                    'error' => $gpt_result['data'],
                    'created_by' => $this->user,
                    'context_id' => $context->id
                ]);
                continue;
            }
            $gpt_response = $gpt_result['data'];
            $gpt_result = $this->textService->forGpt4($gpt_result['data']);
            if($gpt_result['status_code'] == 500)
            {
                FailedContexts::create([
                    'error' => $gpt_result['data'] . "\n" . $gpt_response,
                    'created_by' => $this->user,
                    'context_id' => $context->id
                ]);
                continue;
            }

            $this->questionRepository->saveQuestions($gpt_result['data'], $context->id, $this->user, 'gpt-4');

            sleep(40);
        }
        $process->delete();
    }
}
