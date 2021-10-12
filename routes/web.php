<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\TournamentController::class, 'index'])->name('home');

Route::get('/new-tournament', [App\Http\Controllers\TournamentController::class, 'newTournament'])->name('new.tournament');
Route::post('/idea-store', [App\Http\Controllers\TournamentController::class, 'storeIdea'])->name('idea.store');
Route::post('/eliminate-percipants', [App\Http\Controllers\TournamentController::class, 'elimination'])->name('elimination');
