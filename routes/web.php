<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login'); //login page

Volt::route('/', 'index');

Volt::route('/bidang','direktori-bidang')->name('direktori-bidang');
Volt::route('/bidang/add','form-bidang')->name('add-bidang');

Volt::route('/kegiatan/add','form-kegiatan');
Volt::route('/laporan/add','form-laporan');

Volt::route('/dashboard','dashboard');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

// Protected routes here
Route::middleware('auth')->group(function () {
    Volt::route('/user_management','user-management');
    Volt::route('/users', 'users.index');
    Volt::route('/users/create', 'users.create');
    Volt::route('/users/{user}/edit', 'users.edit');
});
