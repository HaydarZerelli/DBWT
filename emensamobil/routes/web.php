<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BewertungController;

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

Route::get('/', [HomeController::class, 'index']);
Route::post('/', [HomeController::class, 'index']);
Route::get('/anmeldung', [LoginController::class, 'anmeldung']);
Route::post('/anmeldung_verifizieren', [LoginController::class, 'auth']);
Route::get('/abmeldung', [LoginController::class, 'abmeldung']);
Route::get('/bewertung', [BewertungController::class, 'show']);
Route::post('/bewertung_verarbeiten', [BewertungController::class, 'rate']);
