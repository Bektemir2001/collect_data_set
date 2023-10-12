<?php

namespace App\Http\Controllers\Admin\CollectData;

use App\Http\Controllers\Controller;
use App\Models\Context;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function update()
    {

    }

    public function autoGenerate(Request $request)
    {
        $context = Context::where('id', $request->context_id)->first();
        $context = strip_tags($context->context);

    }
}
