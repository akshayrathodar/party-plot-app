<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Search
Route::get('/search', [PageController::class, 'search'])->name('search');

// Party Plots Routes (to be implemented)
Route::prefix('party-plots')->name('party-plots.')->group(function () {
    Route::get('/', [PageController::class, 'partyPlots'])->name('index');
    Route::get('/tag/{slug}', [PageController::class, 'partyPlotsByTag'])->name('tag');
    Route::get('/{slug}', [PageController::class, 'partyPlotDetails'])->name('show');
    Route::get('/create', [PageController::class, 'createPartyPlot'])->name('create');
});

// Authentication Routes (if using Laravel Breeze/Jetstream)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });











