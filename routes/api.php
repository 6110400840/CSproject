<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChapterController;
use App\Http\Controllers\API\ChallengeController;
use App\Http\Controllers\API\ImageController;

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

Route::controller(ChapterController::class)->group(function () {
    Route::post('/createChapter','createChapter');
    Route::post('/updateChapter','updateChapter');
    Route::get('/getAllChapter','getAllChapter');
    Route::get('/getChapter','getChapter');
    Route::get('/getChapterChallenges','getChapterChallenges');
    Route::delete('/deleteChapter','deleteChapter');
    Route::get('/getDeletedChapters','getDeletedChapters');
    Route::post('/deletedChaptersRestore','deletedChaptersRestore');
    Route::post('/deletedChapterRestore','deletedChapterRestore');
    Route::delete('/permanentDeleteChapters','permanentDeleteChapters');
    Route::delete('/permanentDeleteChapter','permanentDeleteChapter');
});

Route::controller(ChallengeController::class)->group(function () {
    Route::post('/createChallenge','createChallenge');
    Route::post('/updateChallenge','updateChallenge');
    Route::get('/getAllChallenge','getAllChallenge');
    Route::get('/getChallenge','getChallenge');
    Route::delete('/deleteChallenge','deleteChallenge');
    Route::get('/getDeletedChallenges','getDeletedChallenges');
    Route::post('/deletedChallengesRestore','deletedChallengesRestore');
    Route::post('/deletedChallengeRestore','deletedChallengeRestore');
    Route::delete('/permanentDeleteChallenges','permanentDeleteChallenges');
    Route::delete('/permanentDeleteChallenge','permanentDeleteChallenge');
    Route::get('/imageCompare','imageCompare');
});