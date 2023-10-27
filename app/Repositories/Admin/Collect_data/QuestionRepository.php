<?php

namespace App\Repositories\Admin\Collect_data;

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

}
