<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebToLeadController;

Route::get('/', function () {
    return view('welcome');
});

// Web-to-Lead form
Route::post('/web-to-lead', [WebToLeadController::class, 'store'])->name('web-to-lead.store');

