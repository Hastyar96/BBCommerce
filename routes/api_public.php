<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;
use App\Http\Controllers\ApiPaymentController;

Route::middleware('auth:sanctum')->group(function (){

    //languages
    Route::get('languages', [ApiPublicController::class, 'languages']);
    //change lang
    Route::post('change/lang', [ApiPublicController::class, 'ChageLang']);
    //profile
    Route::get('user/profile', [ApiPublicController::class, 'UserProfile']);

    //edit profile
    Route::post('edit/profile', [ApiPublicController::class, 'EditUser']);


    Route::post('edit/user-subcity', [ApiPublicController::class, 'EditUserSubCity']);

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

    //all product
    Route::get('products', [ApiPublicController::class, 'allProducts']);

    //oneproduct
    Route::get('one/product/{id}',[ApiPublicController::class ,'OneProduct']);

    //

    //card
    Route::get('get/cart',[ApiPublicController::class ,'GetCart']);
    Route::Post('add/to/cart/{id}',[ApiPublicController::class ,'AddToCart']);
    Route::get('remove/from/cart/{id}',[ApiPublicController::class ,'RemoveFromCart']);
    Route::get('update/cart/{id}/{quantity}',[ApiPublicController::class ,'UpdateCart']);

      //checkout
    Route::post('checkout',[ApiPublicController::class ,'Checkout']);

    Route::post('select/payment-method',[ApiPublicController::class ,'SelectPaymentMethod']);


    Route::get('get/payment-method',[ApiPublicController::class , 'GetPaymentMethod']);

    //fib
    Route::post('/payment/create', [ApiPaymentController::class, 'createPayment']);
    Route::post('/payment-updates', [ApiPaymentController::class, 'handlePaymentUpdate']);
    Route::get('/payment/status/{paymentId}', [ApiPaymentController::class, 'checkPaymentStatus']);
    Route::post('/payment/cancel/{paymentId}', [ApiPaymentController::class, 'cancelPayment']);
    Route::post('/payment/refund/{paymentId}', [ApiPaymentController::class, 'refundPayment']);
    //////////////////

    //thank you page
    Route::get('/thank-you', function () {
        return response()->json(['message' => 'thank you for your payment!']);
    })->name('api.thank-you');





    //search
    Route::get('search',[ApiPublicController::class ,'Search']);

    //cities
    Route::get('cities', [ApiPublicController::class, 'Cities']);
    //subcities
    Route::get('subcities', [ApiPublicController::class, 'SubCities']);
    //subcities by city id
    Route::get('subcities/{id}', [ApiPublicController::class, 'SubCitiesByCityId']);


    //offices
    Route::get('offices', [ApiPublicController::class, 'Offices']);
    //office subcities
    Route::get('office/subcities', [ApiPublicController::class, 'OfficeSubCities']);
    //office subcities by office id
    Route::get('office/subcities/{id}', [ApiPublicController::class, 'OfficeSubCitiesByOfficeId']);
    //office subcities by subcity id
    Route::get('office/subcities/subcity/{id}', [ApiPublicController::class, 'OfficeSubCitiesBySubCityId']);



});
