<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedContexts extends Model
{
    use HasFactory;
    protected $table = 'failed_contexts';
    protected $guarded = false;
}
