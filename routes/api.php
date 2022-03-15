<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChapterController;
use App\Http\Controllers\API\ChallengeController;

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

Route::controller(ChallengeController::class)->group(function () {
    Route::get('/getAllChallenge','getAllChallenge');
    Route::get('/show','show');
    Route::post('/upload','store');
    Route::delete('/delete','destroy');
    Route::post('/test','test');
    Route::post('/test2','test2');
});

Route::controller(ChapterController::class)->group(function () {
    Route::post('/createChapter','createChapter');
    Route::get('/getAllChapter','getAllChapter');
    Route::get('/getChapterChallenges','getChapterChallenges');
    Route::delete('/deleteChapter','deleteChapter');
});