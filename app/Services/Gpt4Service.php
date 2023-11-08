<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Gpt4Service
{
    public function generateQuestion($context)
    {
        $data = [
            'model' => 'gpt-4-1106-preview',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Generate questions and complete answers based on the following text in Kyrgyz language: \n" . $context,
                ],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GPT4_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(100)->post(env('GPT_ENDPOINT'), $data);

        $responseData = $response->json();
        return $responseData;
    }
}
