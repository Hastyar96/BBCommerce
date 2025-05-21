<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;

Route::middleware('auth:sanctum')->group(function (){
    //languages
    Route::get('languages', [ApiPublicController::class, 'languages']);
    //change lang
    Route::post('change/lang', [ApiPublicController::class, 'ChageLang']);
    //profile
    Route::get('user/profile', [ApiPublicController::class, 'UserProfile']);

    //main slider
    Route::get('main/slider', [ApiPublicController::class, 'MainSlider']);

    //products category
    Route::get('product/category', [ApiPublicController::class, 'ProductsCategory']);

    //brand
    Route::get('brand', [ApiPublicController::class, 'Brand']);

    //goal
    Route::get('goal', [ApiPublicController::class, 'Goal']);

    //tag
    Route::get('tag', [ApiPublicController::class, 'Tag']);

    //top 6 products
    Route::get('main/top/products', [ApiPublicController::class, 'TopProducts']);

    //news
    Route::get('news', [ApiPublicController::class, 'News']);

    //videos
    Route::get('videos', [ApiPublicController::class, 'Videos']);

    //oneproduct
    Route::get('one/product/{id}',[ApiPublicController::class ,'OneProduct']);

});
