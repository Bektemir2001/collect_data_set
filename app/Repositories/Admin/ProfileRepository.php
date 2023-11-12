<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Facades\DB;

class ProfileRepository
{
    public function getDiagramData()
    {
        return DB::table('contexts')
            ->join('users', 'users.id', '=', 'contexts.created_by')
            ->select(DB::raw('COUNT(contexts.id) as context_count'), 'users.name')
            ->where('contexts.lang', '=', null)
            ->groupBy('users.id')
            ->get();
    }
}
