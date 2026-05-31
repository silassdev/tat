<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'onboarded'])
    ->name('dashboard');

Route::get('/email/confirmed', function (\Illuminate\Http\Request $request) {
    return view('auth.email-confirmed', [
        'status' => $request->query('status', 'success')
    ]);
})->name('email.confirmed');

Route::middleware(['auth'])->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store']);
});

Route::middleware(['auth', 'onboarded'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
