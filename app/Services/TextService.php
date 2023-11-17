<?php

namespace App\Services;

class TextService
{
    public const QUESTIONS = ['Question:', 'Суроо:', 'question:', 'суроо:', 'Вопрос:', 'вопрос:'];
    public const ANSWERS = ['Answer:', 'Жооп:', 'answer:', 'жооп:', 'Ответ:', 'ответ:'];
    protected TranslateService $translateService;
    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function forGptResponse(array $response): array
    {
        try{
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
            return ['data' => $results, 'status_code' => 200];
        }
        catch (\Exception $exception)
        {
            return ['data' => $exception->getMessage(), 'status_code' => 500];
        }

    }
    public function forGpt4($response_text): array
    {
        try{
            $question_answers = $this->explodeGptResult($response_text);
            $result_array = [];
            for($i = 0; $i < count($question_answers); $i += 2)
            {
                $result_array[] = ['question' => $question_answers[$i], 'answer' => $question_answers[$i + 1]];
            }
            return ['data' => $result_array, 'status_code' => 200];
        }
        catch (\Exception $exception)
        {
            return ['data' => $exception->getMessage(), 'status_code' => 500];
        }

    }
    public function cleanText($text)
    {
        $cleaned_text = html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8');
        return preg_replace('/\s+/u', ' ', $cleaned_text);
    }

    public function explodeGptResult($text)
    {
        $text_array = [];
        $text_tmp = '';
        $is_starting_part_cut = false;
        for ($i = 0; $i < strlen($text); $i++)
        {
            if($text[$i] == "\n")
            {
                if(strlen($text_tmp) != 0 && $text_tmp != "\r")
                {
                    array_push($text_array, $text_tmp);
                    $text_tmp = '';
                    $is_starting_part_cut = false;
                }
            }
            else
            {
                $text_tmp .= $text[$i];
                if($is_starting_part_cut == false)
                {
                    $is_starting_part_cut = $this->is_starting_part($text_tmp);
                    if($is_starting_part_cut) $text_tmp = '';
                }
            }
        }

        if(strlen($text_tmp)) array_push($text_array, $text_tmp);

        return $text_array;
    }

    public function is_starting_part(string $text): bool
    {
        $arr = [];
        foreach (self::ANSWERS as $ANSWER) {
            array_push($arr, [$text, $ANSWER]);
            if(strpos($text, $ANSWER) !== false) return true;
        }

        foreach (self::QUESTIONS as $QUESTION) {
            array_push($arr, [$text, $QUESTION]);
            if(strpos($text, $QUESTION) !== false) return true;
        }
        return false;
    }
}
