<?php

namespace App\Repositories\Admin\Collect_data;

use App\Models\QuestionAnswer;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuestionRepository
{
    public function getQuestionsForCsv(int $limit=100): Collection
    {
        return DB::table('question_answers as q')
            ->join('contexts as c', 'c.id', '=', 'q.context_id')
            ->select('c.context', 'q.question', 'q.answer', 'q.start_index', 'q.end_index')
            ->limit($limit)
            ->get();
    }

    public function getQuestionsForLlama(int $limit=100): Collection
    {
        return DB::table('question_answers as q')
            ->join('contexts as c', 'c.id', '=', 'q.context_id')
            ->select('c.title', 'q.question', 'q.answer', 'c.context', 'c.lang')
            ->limit($limit)
            ->get();
    }

    public function getQuestionsForMistral(array $types)
    {
        return DB::table('question_answers as q')
            ->select( 'q.question', 'q.answer')
            ->whereIn('q.type', $types)
            ->get();
    }

    public function saveQuestions($questions, $context, $user, $type): void
    {
        foreach ($questions as $question)
        {
            QuestionAnswer::create([
                'question' => $question['question'],
                'answer' => $question['answer'],
                'created_by' => $user,
                'context_id' => $context,
                'type' => $type
            ]);
        }
    }

    public function store(array $data, int $user, $type): array
    {

        try {
            $data['created_by'] = $user;
            $data['type'] = $type;
            QuestionAnswer::create($data);
            return ['data' => 'success', 'status_code' => 200];
        }
        catch (Exception $exception)
        {
            dd($exception->getMessage());
            return ['data' => $exception->getMessage(), 'status_code' => 500];
        }
    }

    public function update(QuestionAnswer $questionAnswer, array $data, int $user): array
    {
        try {
            $data['updated_by'] = $user;
            $questionAnswer->update($data);
            return ['data' => 'success', 'status_code' => 200];
        }
        catch (Exception $exception)
        {
            return ['data' => $exception->getMessage(), 'status_code' => 500];
        }
    }

}
