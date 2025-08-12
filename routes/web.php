<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SentEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Show 403 for root URL
Route::get('/', function () {
    abort(403, 'Access Denied');
})->name('home');

// Special auth routes - these should be shared only with authorized personnel
Route::get('/secure/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::get('/secure/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

// Disable default auth routes
Route::match(['get', 'post'], '/login', function () {
    abort(404);
});

Route::match(['get', 'post'], '/register', function () {
    abort(404);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Clients
    Route::resource('clients', ClientController::class);
    
    // Email Templates
    Route::resource('email-templates', EmailTemplateController::class);
    Route::post('/email-templates/preview', [EmailTemplateController::class, 'previewTemplate'])->name('email-templates.preview');
    
    // Email Campaigns
    Route::get('/email-campaigns', [EmailCampaignController::class, 'index'])->name('email-campaigns.index');
    Route::get('/email-campaigns/create', [EmailCampaignController::class, 'create'])->name('email-campaigns.create');
    Route::post('/email-campaigns', [EmailCampaignController::class, 'store'])->name('email-campaigns.store');
    Route::get('/email-campaigns/{emailJob}', [EmailCampaignController::class, 'show'])->name('email-campaigns.show');
    Route::delete('/email-campaigns/{emailJob}', [EmailCampaignController::class, 'destroy'])->name('email-campaigns.destroy');
    
    // Sent Emails
    Route::get('/sent-emails', [SentEmailController::class, 'index'])->name('sent-emails.index');
    Route::get('/sent-emails/{sentEmail}', [SentEmailController::class, 'show'])->name('sent-emails.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';