<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\JobOfferController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function (){
    
Route::apiResource('applications',ApplicationController::class);
Route::apiResource('job-offers',JobOfferController::class);
Route::get('stats/candidate', [StatsController::class , 'candidate']);
Route::get('stats/recruiter', [StatsController::class , 'recruiter']);
});