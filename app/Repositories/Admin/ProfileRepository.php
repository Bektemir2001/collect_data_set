<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProfileRepository
{
    public function getDiagramData() : Collection
    {
        return DB::table('question_answers as q')
            ->join('users', 'users.id', '=', 'q.created_by')
            ->select(DB::raw('COUNT(q.id) as context_count'), 'users.name')
            ->where('q.type', '=', 'amount')
            ->groupBy('users.id')
            ->get();
    }

    public function getGraphicData(Carbon $end_date, Carbon $start_date, int $user) : Collection
    {
        return DB::table('contexts')
            ->join('users', 'users.id', '=', 'contexts.created_by')
            ->select(
                DB::raw('DATE_FORMAT(contexts.created_at, "%Y-%m-%d") as day'),
                DB::raw('COUNT(contexts.id) as context_count'))
            ->where('users.id', '=', $user)
            ->where('contexts.created_at', '<=', $end_date)
            ->where('contexts.created_at', '>=', $start_date)
            ->groupBy('day')
            ->get();
    }
}
