<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MPESAController;
use App\Http\Controllers\PlayersController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('admin.dashboard');
// });
Route::get('/', [AdminController::class, 'index'])->name('dashboard');
Route::get('/radios/{radio}', [AdminController::class, 'getRadio'])->name('getradio'); //get single radio admin data
Route::get('/sms', [AdminController::class, 'sms'])->name('sms');
Route::post('/sms/{sms}', [AdminController::class, 'updatesms'])->name('updatesms');
Route::get('/mpesa', [AdminController::class, 'mpesa'])->name('mpesa');
Route::post('/addmpesacode', [AdminController::class, 'addCode'])->name('addCode');
Route::get('/radio', [AdminController::class, 'radio'])->name('radio');
Route::post('/addradio', [AdminController::class, 'addRadio'])->name('addRadio');
Route::get('/registerurl/{id}', [AdminController::class, 'URLregister'])->name('registerurl');
Auth::routes();

Route::middleware(['auth'])->controller(PlayersController::class)->group(function () {
    Route::get('/players', 'players')->name('players');
    Route::get('/online/{index}', 'online')->name('online');
    Route::post('/filter', 'filter')->name('filter');
    Route::get('/winners', 'winners')->name('winners');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

//mpesa routes
Route::get('/transaction/token', [MPESAController::class, 'generateAccessToken'])->name('apptoken');
// Route::get('/transaction/registerurl', [MPESAController::class, 'registerURL']);
Route::get('/transaction/simulate', [MPESAController::class, 'simulateTransaction']);
