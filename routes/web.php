<?php

use App\Http\Controllers\Admin\CollectData\ContextController;
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

Route::get('/translate', function (){
    $translator = new GoogleTranslate();
    $translator->setSource('en'); // Исходный язык
    $translator->setTarget('ky'); // Целевой язык

    $translatedText = $translator->translate('Hello, world!');
    return $translatedText;
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::get('/squid2', [SQuid2Controller::class, 'index'])->name('admin.squid2.index');
    Route::get('/get/data', [SQuid2Controller::class, 'getData'])->name('getdata');
    Route::post('/translate', [SQuid2Controller::class, 'translate'])->name('translate');


    Route::group(['prefix' => 'contexts'], function (){
        Route::get('/', [ContextController::class, 'index'])->name('context.index');
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

