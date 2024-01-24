<?php

use App\Http\Controllers\Admin\CollectData\ContextController;
use App\Http\Controllers\Admin\CollectData\Export\ExportQuestionController;
use App\Http\Controllers\Admin\CollectData\IndexingController;
use App\Http\Controllers\Admin\CollectData\QuestionAnswerController;
use App\Http\Controllers\Admin\CollectData\Translate\TranslateContextController;
use App\Http\Controllers\Admin\CollectData\UploadController;
use App\Http\Controllers\Admin\CommonCrawlController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Gpt4Controller;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SQuid2Controller;
use App\Http\Controllers\Admin\User\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FailedContentsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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



Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::get('/squid2', [SQuid2Controller::class, 'index'])->name('admin.squid2.index');
    Route::get('/get/data', [SQuid2Controller::class, 'getData'])->name('getdata');
    Route::post('/translate', [SQuid2Controller::class, 'translate'])->name('translate');

    Route::group(['prefix' => 'questions'], function (){
        Route::get('/', [QuestionController::class, 'index'])->name('admin.question');
        Route::post('/upload/csv', [QuestionController::class, 'uploadCsv'])->name('admin.question.upload.csv');
        Route::post('/export/csv', [QuestionController::class, 'export'])->name('admin.question.export.csv');
    });

    Route::group(['prefix' => 'contexts'], function (){
        Route::get('/', [ContextController::class, 'index'])->name('context.index');
        Route::get('/create', [ContextController::class, 'create'])->name('context.create');
        Route::get('/{context}', [ContextController::class, 'show'])->name('context.show');
        Route::post('/', [ContextController::class, 'store'])->name('context.store');
        Route::post('/update/{context}', [ContextController::class, 'update'])->name('context.update');


        Route::group(['prefix' => 'translate'], function (){
            Route::get('/index', [TranslateContextController::class, 'index'])->name('context.translate.index');
            Route::get('/show/{context}', [TranslateContextController::class, 'show'])->name('context.translate.show');
            Route::post('/upload/csv', [TranslateContextController::class, 'uploadCSV'])->name('context.translate.upload_csv');

        });
    });

    Route::group(['prefix' => 'questions'], function (){
        Route::post('/update', [QuestionAnswerController::class, 'update'])->name('question.update');
        Route::post('/store', [QuestionAnswerController::class, 'store'])->name('question.store');
        Route::post('/manual/store', [QuestionController::class, 'store'])->name('question.manual.store');
        Route::post('/auto/generate', [QuestionAnswerController::class, 'autoGenerate'])->name('question.autogenerate');
        Route::post('/remove', [QuestionAnswerController::class, 'remove'])->name('question.remove');
        Route::post('/save/generated/questions/{context}', [QuestionController::class, 'saveGeneratedQuestions'])->name('question.save.generated');
    });

    Route::group(['prefix' => 'csv'], function (){
        Route::post('/upload', [UploadController::class, 'CSV'])->name('upload.csv');
        Route::post('/upload/alpaca/kg', [UploadController::class, 'alpacaKG'])->name('alpaca.kg');
        Route::post('/export/questions', [ExportQuestionController::class, 'csv'])->name('export.questions');
        Route::post('/export/questions/for/llama', [ExportQuestionController::class, 'forLama'])->name('export.questions.for.lama');
    });

    Route::group(['prefix' => 'profile'], function (){
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('/context/diagram', [ProfileController::class, 'getDiagram'])->name('admin.profile.diagram');
        Route::post('/context/graphic', [ProfileController::class, 'getGraphic'])->name('admin.profile.graphic');
    });


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/indexing', [IndexingController::class, 'make'])->name('indexing');


    Route::get('/failed/contexts', [FailedContentsController::class, 'index'])->name('failed.context');
    Route::get('/failed/contexts/delete/{failed_context_id}', [FailedContentsController::class, 'justDelete'])->name('failed.context.delete');
    Route::post('/failed/contexts/save/question', [FailedContentsController::class, 'saveQuestionAndDeleteFailedContext'])->name('failed.context.save.question');

    Route::group(['prefix' => 'commncrawl'], function (){
        Route::get('/', [CommonCrawlController::class, 'index'])->name('crawl.index');
        Route::post('/show', [CommonCrawlController::class, 'show'])->name('crawl.show');
        Route::post('/black/list', [CommonCrawlController::class, 'blackList'])->name('crawl.black.list');
        Route::post('/white/list', [CommonCrawlController::class, 'whiteList'])->name('crawl.white.list');
        Route::post('/get/siteContent', [CommonCrawlController::class, 'getSiteContent'])->name('crawl.get.site.content');
    });

});


Route::group(['prefix' => 'auth'], function (){
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login.index');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/register', [RegisterController::class, 'index'])->name('admin.register.index');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register');
});

Route::group(['prefix' => 'gpt4'], function (){
    Route::post('/generate/question', [Gpt4Controller::class, 'generateQuestion'])->name('gpt4.question.generate');
    Route::post('/generate/default/question', [Gpt4Controller::class, 'defaultGenerating'])->name('gpt4.question.default.generate');
});

Route::get('/', function (){
    return redirect()->route('admin.index');
});

Route::get('/failed-jobs', function (){
    dd(DB::table('failed_jobs')->get());
});

Route::get('/failed-contents', function (){
    dd(DB::table('failed_contexts')->get());
});

//Route::get('/extra/contexts', function (){
//    $contexts = \App\Models\Context::whereRaw('CHAR_LENGTH(context) < 400')->get();
//    foreach ($contexts as $context)
//    {
//        if(!count($context->questions))
//        {
//            $context->delete();
//        }
//    }
//    dd($contexts);
//});

