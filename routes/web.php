<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Middleware\officer;
use App\Http\Middleware\admin;

// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login'); //login page

Volt::route('/', 'index')->name('index');

Route::middleware([officer::class])->group(function () {
    Volt::route('/laporan','direktori-laporan')->name('direktori-laporan');
    Volt::route('/laporan/add','form-laporan')->name('add-laporan');
    Volt::route('/laporan/{laporan}/edit','form-edit-laporan')->name('edit-laporan');
});

Route::middleware([admin::class])->group(function () {
    Volt::route('/bidang','direktori-bidang')->name('direktori-bidang');
    Volt::route('/bidang/add','form-bidang')->name('add-bidang');
    Volt::route('/bidang/{bidang}/edit','form-edit-bidang')->name('edit-bidang');

    Volt::route('/program','direktori-program')->name('direktori-program');
    Volt::route('/program/add','form-program')->name('add-program');
    Volt::route('/program/{program}/edit','form-edit-program')->name('edit-program');

    Volt::route('/kegiatan','direktori-kegiatan')->name('direktori-kegiatan');
    Volt::route('/kegiatan/add','form-kegiatan')->name('add-kegiatan');
    Volt::route('/kegiatan/{kegiatan}/edit','form-edit-kegiatan')->name('edit-kegiatan');
});

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});
