<?php

namespace App\Repositories\Admin\Collect_data;

use App\Models\QuestionAnswer;
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

}
