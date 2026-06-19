<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobOfferController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function (){

Route::post('/logout' , [AuthController::class , 'logout']);

Route::post('job-offers', [JobOfferController::class , 'store']);
Route::put('job-offers/{jobOffer}', [JobOfferController::class , 'update']);
Route::delete('job-offers/{jobOffer}', [JobOfferController::class , 'destroy']);

Route::apiResource('applications',ApplicationController::class);

Route::get('stats/candidate', [StatsController::class , 'candidate']);
Route::get('stats/recruiter', [StatsController::class , 'recruiter']);

});

Route::post('/login', [AuthController::class , 'login']);
Route::get('job-offers',[JobOfferController::class , 'index']);
Route::get('job-offers/{jobOffer}',[JobOfferController::class , 'show']);