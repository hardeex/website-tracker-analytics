<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\EmailController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');


Route::get('/verify-email', [EmailController::class, 'verifyEmail'])->name('verify.email'); 