<?php

namespace App\Services;

class NewTextService
{
    public const QUESTIONS = ['Question:', 'Суроо:', 'question:', 'суроо:', 'Вопрос:', 'вопрос:'];
    public const ANSWERS = ['Answer:', 'Жооп:', 'answer:', 'жооп:', 'Ответ:', 'ответ:'];

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

    public function explodeGptResult($text): array
    {
        $text_array = [];
        $word = '';
        $sentence = '';
        for ($i = 0; $i < strlen($text); $i++)
        {
            $word .= $text[$i];
            if($this->is_starting_part($word))
            {
                if(strlen($sentence))
                {
                    $text_array[] = $sentence;
                    $sentence = '';
                }
                $word = '';
            }
            elseif($text[$i] == " " || $text[$i] == "\n")
            {
                $sentence .= $word;
                $word = '';
            }
        }
        if (strlen($word)) $sentence .= $word;
        if(strlen($sentence)) $text_array[] = $sentence;
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
