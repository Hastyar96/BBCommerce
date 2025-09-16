<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;
use App\Http\Controllers\ApiAdminDataController;
use App\Http\Controllers\ApiAdminOrderController;

Route::middleware('auth:sanctum')->group(function (){

    //Ordes
    Route::get('admin/get/orders/{type_id}',[ApiAdminOrderController::class ,'GetOrders']);

    Route::get('admin/order/{id}', [ApiAdminOrderController::class, 'getOrder']);

    Route::get('admin/order/accept/{id}',[ApiAdminOrderController::class ,'AcceptOrder']);
    Route::post('admin/order/delivery/{id}',[ApiAdminOrderController::class ,'DeliveryOrder']);
    Route::get('admin/order/reject/{id}',[ApiAdminOrderController::class ,'RejectOrder']);
    Route::get('admin/order/complete/{id}',[ApiAdminOrderController::class ,'CompleteOrder']);

    Route::get('admin/get/order/status/name',[ApiAdminOrderController::class ,'GetOrderStatus']);
});
