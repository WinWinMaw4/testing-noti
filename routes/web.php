<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SharedContactController;
use App\Http\Controllers\LanguageController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware("auth")->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource("/contact",ContactController::class);
    Route::resource("/shared-contact",SharedContactController::class);
    Route::post("/contact-bulk-action",[ContactController::class,'bulkAction'])->name("contact.bulkAction");
    Route::post("/contact-bulk-share",[ContactController::class,'bulkShare'])->name("contact.bulkShare");
    Route::get('/lang/{locale}', [LanguageController::class,'lang_change'])->name('lang.change');
});

