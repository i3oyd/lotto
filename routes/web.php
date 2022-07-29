<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LottoResultsController;
use App\Http\Controllers\PagesController;

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

Route::get('/',[LottoResultsController::class,'allLatestResults']);
Route::get('/results',[LottoResultsController::class,'importData']);
Route::get('/csv',[LottoResultsController::class,'importCSV']);
Route::get('/latest-result/{game}',[LottoResultsController::class,'latestResults']);


//PagesController Routes
Route::get('make-parenthesis', [PagesController::class,'make_parenthesis']);


