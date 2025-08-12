<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return  redirect('https://britishbody.uk/');
});
Route::get('/contact', function () {
    return  redirect('https://britishbody.uk/contact');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
