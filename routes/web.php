<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LeaderboardController;

// Leaderboard
Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::post('/leaderboard/recalculate', [LeaderboardController::class, 'recalculate'])->name('leaderboard.recalculate');
Route::get('/leaderboard/search', [LeaderboardController::class, 'search'])->name('leaderboard.search');

// Route::get('/', function () {
//     return view('welcome');
// });
