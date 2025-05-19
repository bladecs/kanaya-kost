<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MessageController;

// Rute yang bisa diakses SEMUA ORANG (tanpa middleware)
Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/list-room', function () {
    return view('dashboard.list-room');
})->name('listroom');

Route::get('/detailroom', [CustomerController::class,'rooms'])->name('detailroom');

// Rute untuk GUEST (hanya bisa diakses jika BELUM LOGIN)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function (Request $request) {
        return view('auth.auth', ['request' => $request]);
    })->name('login.page');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Rute untuk USER yang sudah login (hanya bisa diakses jika SUDAH LOGIN)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile-user', [CustomerController::class, 'profile'])->name('profileuser');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Middleware group for admin
Route::middleware(['auth', 'IsAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/add-room', [AdminController::class, 'store'])->name('room.store');
    Route::post('/update-room', [AdminController::class, 'update'])->name('room.update');
    Route::post('/delete-room', [AdminController::class, 'destroy'])->name('room.delete');
    Route::get('/users',[AdminController::class, 'user'])->name('user');
});

Route::get('/messages', [MessageController::class, 'index']);
Route::post('/messages', [MessageController::class, 'store']);
Route::post('/messages/{userId}/mark-as-read', [MessageController::class, 'markAsRead']);
Route::get('/user/messages', [MessageController::class, 'userMessages']);
Route::post('/user/messages/mark-as-read', [MessageController::class, 'markUserMessagesAsRead']);