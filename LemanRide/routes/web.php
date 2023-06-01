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

// route to the home page rendered by the renderHome method of the WindController
Route::get('/', [WindController::class, 'renderHome'])->name('home');

// route to the stations page rendered by the renderStations method of the WindController
Route::get('/stations', [WindController::class, 'renderStations'])->name('stations');

// route to the about page rendered by the renderAbout method of the WindController
Route::get('/about', [WindController::class, 'renderAbout'])->name('about');

// route to the contact page rendered by the renderContact method of the WindController
Route::get('/contact', [WindController::class, 'renderContact'])->name('contact');


