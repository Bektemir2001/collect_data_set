<?php

use App\Http\Controllers\TranslateController;
use App\Models\Context;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/translate/alpaca', [TranslateController::class, 'alpaca']);

Route::get('contexts/count', function (){

    $contexts = Context::where('id', '>', 61833)
        ->where('id', '<', 84208)
        ->get();
    $arr = [];
    foreach ($contexts as $context)
    {
        if(strlen($context->context) > 4000) $arr[] = ['id' => $context->id, 'context' => $context->context];
    }

    dd($arr);
});

