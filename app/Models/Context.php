<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Context extends Model
{
    use HasFactory;
    protected $table = 'contexts';
    protected $guarded = false;


    public function questions()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
