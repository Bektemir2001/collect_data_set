<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadProcess extends Model
{
    use HasFactory;

    protected $table = 'upload_processes';
    protected $guarded = false;
}
