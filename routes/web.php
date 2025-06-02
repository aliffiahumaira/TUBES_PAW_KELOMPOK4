<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Mews\Captcha\Captcha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes that require login
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Ringkasan Bulanan
    // URL: /summary/monthly?monthyear=YYYY-MM
    Route::get('/summary/monthly', [SummaryController::class, 'monthly'])
         ->name('summary.monthly');

    // Ringkasan Keseluruhan
    // URL: /summary/all
    Route::get('/summary/all', [SummaryController::class, 'all'])
         ->name('summary.all');

    // Monthly (fungsi lain di HomeController, misalnya untuk laporan grafik)
    Route::get('/monthly/index', [HomeController::class, 'monthly'])->name('monthly.index');

    // Notes
    Route::resource('notes', NoteController::class)->except(['show']);

    // Incomes
    Route::resource('incomes', IncomeController::class)->except(['show']);

    // Expenses
    Route::resource('expenses', ExpenseController::class)->except(['show']);
});

// Captcha
// Captcha reload
Route::get('/reload-captcha', function () {
    $config = request()->get('config', 'default'); 
    return response()->json([
        'captcha' => captcha_img($config),
    ]);
});

