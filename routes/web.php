<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','verified'])->group(function (){
    Route::get('/dashboard' , [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('applications', ApplicationController::class);

    Route::post('job-offers', [JobOfferController::class , 'store'])->name('job-offers.store');
    Route::put('job-offers/{jobOffer}', [JobOfferController::class , 'update'])->name('job-offer.update');
    Route::delete('job-offers/{jobOffer}', [JobOfferController::class , 'destroy'])->name('job-offer.destroy');

});

Route::get('job-offers' , [JobOfferController::class , 'index'])->name('job-offers.index');
Route::get('job-offers/{jobOffer}' , [JobOfferController::class , 'show'])->name('job-offers.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
