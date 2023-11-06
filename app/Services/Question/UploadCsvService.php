<?php

namespace App\Services\Question;


use App\Models\QuestionAnswer;
use App\Models\UploadProcess;
use App\Services\TranslateService;

class UploadCsvService
{
    public function upload($data, $user, $source_lang, $file_path): void
    {
        $translator = new TranslateService();
        $length = count($data);
        $i = 0;

        $process = UploadProcess::create([
            'file_name' => $file_path,
            'model' => 'QuestionAnswer',
            'present' => 0
        ]);
        foreach ($data as $record) {
            if (!isset($record['instruction']) || !isset($record['output'])) {
                continue;
            }
            $question = $translator->translate($record['instruction'], $source_lang, 'KG')['result'];
            $answer = $translator->translate($record['output'], $source_lang, 'KG')['result'];

            if($question == null){
                $i += 1;
                continue;
            }
            if($answer == null){
                $i += 1;
                continue;
            }
            QuestionAnswer::create(
                [
                    'original_question' => $record['instruction'],
                    'original_answer' => $record['output'],
                    'question' =>$question,
                    'answer' => $answer,
                    'created_by' => $user,
                    'type' => 'translated_mistral'
                ]
            );

            if($i % 10 == 0)
            {
                $process->update(['present' => ($i / $length) * 100]);
                sleep(2);
            }
        }

        $process->delete();
    }
}
