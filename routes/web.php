<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

// Route tampilan login & register
Route::get('/', function () {
    return view('auth.auth');
});
// Route untuk proses login
Route::post('/login', [authController::class, 'login'])->name('login');
// Route untuk proses register
Route::post('/register', [authController::class, 'register'])->name('register');
// Route untuk proses logout
Route::get('/logout',[authController::class,'logout'])->name('logout');

// Route tampilan dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::get('/list-room', function () {
        return view('dashboard.list-room');
    })->name('listroom');
    
    Route::get('/detail-room', function () {
        return view('dashboard.detail-room');
    })->name('detailroom');

    Route::get('/profile-user', function () {
        return view('dashboard.profile');
    })->name('profileuser');
});


