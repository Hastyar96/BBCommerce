<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;

use App\Models\User;

include('api_public.php');



Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('verify', [ApiAuthController::class, 'verifyOTP']);

Route::post('/send-notification', [ApiAuthController::class, 'sendNotification']);

Route::middleware('auth:sanctum')->post('logout', [ApiAuthController::class, 'logout']);


