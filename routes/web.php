<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/support', 'support')->name('support');
