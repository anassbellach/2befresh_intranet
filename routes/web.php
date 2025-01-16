<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GebruikersController;
use App\Http\Controllers\KlantenController;
use App\Http\Controllers\KlantenMapController;
use App\Http\Controllers\LeveranciersController;
use App\Http\Controllers\LeveranciersMapController;
use App\Http\Controllers\ReferralController;
use App\Mail\UserRegisteredMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Home route
    Route::get('/', [DashboardController::class, 'index']);
    // Referral routes
    Route::name('referral.restore')->put('referral/{referral}/restore', [ReferralController::class, 'restore'])->withTrashed();
    Route::resource('referral', ReferralController::class)->withTrashed();

    // Klant routes
    Route::get('/klant/statistieken', [KlantenController::class, 'statistieken'])->withTrashed();
    Route::name('klant.restore')->put('klant/{klant}/restore', [KlantenController::class, 'restore'])->withTrashed();
    Route::get('/klant/kaart', [KlantenMapController::class, 'index']);
    Route::get('/klant/update-coordinates', [KlantenController::class, 'updateCoordinates'])->name('klanten.update-coordinates');
    Route::resource('klant', KlantenController::class)->withTrashed();

    // Contact routes
    Route::name('contact.restore')->put('contact/{contact}/restore', [ContactenController::class, 'restore'])->withTrashed();
    Route::resource('contact', ContactenController::class)->withTrashed();

    // Leverancier routes
    Route::get('/leverancier/kaart', [LeveranciersMapController::class, 'index']);
    Route::get('/leverancier/statistieken', [LeveranciersController::class, 'statistieken'])->withTrashed();
    Route::get('/leverancier/update-coordinates', [LeveranciersController::class, 'updateCoordinates']);
    Route::name('leverancier.restore')->put('leverancier/{leverancier}/restore', [LeveranciersController::class, 'restore'])->withTrashed();
    Route::resource('leverancier', LeveranciersController::class)->withTrashed();

    // Gebruiker routes
    Route::name('gebruiker.restore')->put('gebruiker/{gebruiker}/restore', [GebruikersController::class, 'restore'])->withTrashed();
    Route::resource('gebruiker', GebruikersController::class)->withTrashed();

    // Update Created At
    Route::get('/update-created-at', [KlantenController::class, 'updateCreatedAtWithChunking']);
});

// Auth routes
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

// Email Verification routes
Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();

    // Send custom verification email
    Mail::to($user->email)->send(new UserRegisteredMail($user));

    return back()->with('success', 'De verificatielink is opnieuw verzonden!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
