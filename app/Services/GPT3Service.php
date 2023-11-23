<?php

namespace App\Services;
use GuzzleHttp\Client;

class GPT3Service
{
    protected TextService $textService;
    public function __construct(TextService $textService)
    {
        $this->textService = $textService;
    }


    public function generateQuestionAndAnswer($text):array
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/engines/text-davinci-003/completions', [
            'headers' => [
                'Authorization' => 'Bearer '.env('GPT_KEY'),
            ],
            'json' => [
                'prompt' => "Generate questions and answers based on the following text: $text",
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ],
        ]);
        $responseData = json_decode($response->getBody(), true);
        return $this->textService->forGptResponse($responseData['choices']);
    }

}
