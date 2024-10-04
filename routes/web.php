<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/applicants-report', [ReportsController::class, 'generateApplicantsReport']);

Route::get('/hired-applicants-report', [ReportsController::class, 'generateHiredApplicantsReport']);

Route::get('/rejected-applicants-report', [ReportsController::class, 'generateRejectedApplicantsReport']);

Route::get('/returnee-applicants-report', [ReportsController::class, 'generateReturneeApplicantsReport']);

Route::get('/active-users-report', [ReportsController::class, 'generateActiveUserReport']);