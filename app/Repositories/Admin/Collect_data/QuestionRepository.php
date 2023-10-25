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
            ->where('c.lang', 'EN')
            ->limit($limit)
            ->get();
    }

}
