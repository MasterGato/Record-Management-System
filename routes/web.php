<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ApplicationController;
use App\Filament\Exports\ApplicationExporter;
use Filament\Actions\Exports\Models\Export;

Route::get('', [ApplicationController::class, 'showForm']);
Route::post('submitForm', [ApplicationController::class, 'submitForm'])->name('submitForm');

Route::get('/applicants-report', [ReportsController::class, 'generateApplicantsReport']);

Route::get('/hired-applicants-report', [ReportsController::class, 'generateHiredApplicantsReport']);

Route::get('/rejected-applicants-report', [ReportsController::class, 'generateRejectedApplicantsReport']);

Route::get('/returnee-applicants-report', [ReportsController::class, 'generateReturneeApplicantsReport']);

Route::get('/active-users-report', [ReportsController::class, 'generateActiveUserReport']);

Route::get('/', [ApplicationController::class, 'showForm'])->name('showForm');

Route::post('/submit-form', [ApplicationController::class, 'submitForm'])->name('submitForm');
