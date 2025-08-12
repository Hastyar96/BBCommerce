<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;
use App\Http\Controllers\PublicController;



Route::get('/', [PublicController::class, 'Home']);
Route::get('/change/lang/{id}', [PublicController::class, 'changeLang']);

Route::get('/products', [PublicController::class, 'Products']);
Route::get('/product/{product_id}', [PublicController::class, 'oneProduct']);



Route::get('/contact', [PublicController::class, 'Contact']);
Route::get('/about', [PublicController::class, 'About']);
