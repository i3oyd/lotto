<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LottoResultsController;
use App\Http\Controllers\API\LottoResultsController as LottoAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/latest-result',[LottoAPIController::class,'latestResult']);
Route::get('/latest-results/{game}',[LottoAPIController::class,'lottoResults']);
Route::get('/stats',[LottoAPIController::class,'stats']);
Route::post('/search-results',[LottoResultsController::class,'searchResults']);