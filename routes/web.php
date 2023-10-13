<?php

use App\Http\Controllers\Admin\CollectData\ContextController;
use App\Http\Controllers\Admin\CollectData\QuestionAnswerController;
use App\Http\Controllers\Admin\CollectData\Translate\TranslateContextController;
use App\Http\Controllers\Admin\CollectData\UploadController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\SQuid2Controller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Stichoza\GoogleTranslate\GoogleTranslate;

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::get('/squid2', [SQuid2Controller::class, 'index'])->name('admin.squid2.index');
    Route::get('/get/data', [SQuid2Controller::class, 'getData'])->name('getdata');
    Route::post('/translate', [SQuid2Controller::class, 'translate'])->name('translate');


    Route::group(['prefix' => 'contexts'], function (){
        Route::get('/', [ContextController::class, 'index'])->name('context.index');
        Route::get('/create', [ContextController::class, 'create'])->name('context.create');
        Route::get('/{context}', [ContextController::class, 'show'])->name('context.show');
        Route::post('/', [ContextController::class, 'store'])->name('context.store');
        Route::post('/update/{context}', [ContextController::class, 'update'])->name('context.update');

        Route::group(['prefix' => 'translate'], function (){
            Route::get('/index', [TranslateContextController::class, 'index'])->name('context.translate.index');
            Route::post('/upload/csv', [TranslateContextController::class, 'uploadCSV'])->name('context.translate.upload_csv');
        });
    });

    Route::group(['prefix' => 'questions'], function (){
        Route::post('/update', [QuestionAnswerController::class, 'update'])->name('question.update');
        Route::post('/store', [QuestionAnswerController::class, 'store'])->name('question.store');
        Route::post('/auto/generate', [QuestionAnswerController::class, 'autoGenerate'])->name('question.autogenerate');
        Route::post('/remove', [QuestionAnswerController::class, 'remove'])->name('question.remove');
    });

    Route::group(['prefix' => 'csv'], function (){
        Route::post('/upload', [UploadController::class, 'CSV'])->name('upload.csv');
    });
});


Route::group(['prefix' => 'auth'], function (){
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login.index');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/register', [RegisterController::class, 'index'])->name('admin.register.index');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register');
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

