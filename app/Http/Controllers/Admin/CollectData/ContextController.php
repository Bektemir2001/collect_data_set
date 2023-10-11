<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Models\Context;
use Illuminate\Http\Request;

class ContextController extends Controller
{
    public function index()
    {
        $contexts = Context::all();
        return view('admin.context.index', compact('contexts'));
    }
}
