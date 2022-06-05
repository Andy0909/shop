<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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



Route::get('/', [HomeController::class , 'index'])->name('index');
Route::get('/contact_us', [HomeController::class , 'contact_us'])->name('contact_us');
Route::post('/login_token',[AuthController::class,'loginToken'])->name('loginToken');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');