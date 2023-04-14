<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HashingController;

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

Route::get('/', function () {
    return view('hashing');
});
Route::get('/home', [App\Http\Controllers\HashingController::class, 'index'])->name('home');
Route::post('/home/hashing', [App\Http\Controllers\HashingController::class, 'generate'])->name('hashing');
Route::post('/home/verify', [App\Http\Controllers\HashingController::class, 'verify'])->name('verify');

