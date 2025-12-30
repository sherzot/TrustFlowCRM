<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebToLeadController;

Route::get('/', function () {
    return view('welcome');
});

// Web-to-Lead form
Route::post('/web-to-lead', [WebToLeadController::class, 'store'])->name('web-to-lead.store');

// Client Portal routes
Route::get('/client-portal/login', [\App\Http\Controllers\ClientPortalController::class, 'login'])->name('client-portal.login');
Route::get('/client-portal', [\App\Http\Controllers\ClientPortalController::class, 'dashboard'])->name('client-portal.dashboard');
Route::get('/client-portal/project/{id}', [\App\Http\Controllers\ClientPortalController::class, 'project'])->name('client-portal.project');
Route::get('/client-portal/invoice/{id}', [\App\Http\Controllers\ClientPortalController::class, 'invoice'])->name('client-portal.invoice');
Route::match(['get', 'post'], '/client-portal/contract/{id}/sign', [\App\Http\Controllers\ClientPortalController::class, 'signContract'])->name('client-portal.sign-contract');

// PDF routes (protected by Filament auth middleware)
Route::middleware(['auth'])->group(function () {
    // Contract PDF routes
    Route::get('/contracts/{contract}/pdf/view', [\App\Http\Controllers\ContractPdfController::class, 'view'])->name('contracts.pdf.view');
    Route::get('/contracts/{contract}/pdf/download', [\App\Http\Controllers\ContractPdfController::class, 'download'])->name('contracts.pdf.download');
    
    // Project PDF routes
    Route::get('/projects/{project}/pdf/view', [\App\Http\Controllers\ProjectPdfController::class, 'view'])->name('projects.pdf.view');
    Route::get('/projects/{project}/pdf/download', [\App\Http\Controllers\ProjectPdfController::class, 'download'])->name('projects.pdf.download');
});

