<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WindController;

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

Route::get('/', [WindController::class, 'renderIndex'])->name('home');

Route::get('/stations', [WindController::class, 'renderStations'])->name('stations');

Route::get('/about', [WindController::class, 'renderAbout'])->name('about');

Route::get('/contact', [WindController::class, 'renderContact'])->name('contact');


