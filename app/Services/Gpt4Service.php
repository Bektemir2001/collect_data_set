<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Gpt4Service
{
    public function generateQuestion($context): array
    {
        $data = [
            'model' => 'gpt-4-1106-preview',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Generate questions as much as possible and detailed answers based on the following text in Kyrgyz language return 'Question:' 'Answer:' \n"  . $context,
                ],
            ],
        ];

        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GPT4_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(200)->post(env('GPT_ENDPOINT'), $data);
            $responseData = $response->json();
            return ['data' => $responseData['choices'][0]['message']['content'], 'status_code' => 200];
        }
        catch (\Exception $exception)
        {
            return ['data' => $exception->getMessage(), 'status_code' => 500];
        }

    }
}
