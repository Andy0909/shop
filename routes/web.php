<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
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



Route::get('/', [HomeController::class , 'index'])->name('home');

Route::get('/contact_us', [HomeController::class , 'contact_us'])->name('contact_us');

Route::post('/login_token',[AuthController::class,'loginToken'])->name('loginToken');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/member',[MemberController::class,'index'])->name('member');
Route::post('/add_subscribe',[MemberController::class,'store'])->name('addSubscribe');

Route::get('/orders',[OrderController::class,'index'])->name('order');
Route::post('/add_orders',[OrderController::class,'store'])->name('addOrders');
Route::post('/delete_orders',[OrderController::class,'destroy'])->name('deleteOrders');
Route::get('/remove_orders',[OrderController::class,'remove'])->name('removeOrders');

Route::get('/categories/{category_slug?}',[CategoryController::class,'index'])->name('category');