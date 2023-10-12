<?php

namespace App\Services;

class TextService
{
    protected TranslateService $translateService;
    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function forGptResponse(array $response): array
    {
        $results = [];
        foreach ($response as $text)
        {
            $tmp = explode("\n", $text['text']);
            for($i = 0; $i < count($tmp)-1; $i++)
            {
                if(strlen($tmp[$i]) < 4 || strlen($tmp[$i + 1]) < 4) continue;
                if($tmp[$i][0] == 'Q'  && $tmp[$i+1][0] == 'A')
                {
                    $question = $this->translateService->translate($tmp[$i], 'EN', 'KG');
                    if($question['code'] == 200)
                    {
                        $answer = $this->translateService->translate($tmp[$i+1], 'EN', 'KG');
                        if($answer['code'] == 200){
                            $q = [
                                'question' => $question['result'],
                                'answer' => $answer['result']
                                ];
                            array_push($results, $q);
                        }

                    }

                }
            }

        }
        return $results;
    }
}
