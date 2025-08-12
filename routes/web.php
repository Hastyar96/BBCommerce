<?php

use Illuminate\Support\Facades\Route;

include('public.php');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


