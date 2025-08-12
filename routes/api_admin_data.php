<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiPublicController;
use App\Http\Controllers\ApiAdminDataController;
use App\Http\Controllers\ApiAdminOrderController;

Route::middleware('auth:sanctum')->group(function (){
    // Data
    Route::get('admin/get/cities', [ApiAdminDataController::class, 'GetCities']);
    Route::post('admin/add/city', [ApiAdminDataController::class, 'AddCity']);
    Route::post('admin/edit/city/{id}', [ApiAdminDataController::class, 'EditCity']);

    Route::get('admin/get/city-langs/{city_id}', [ApiAdminDataController::class, 'GetCityLangs']);
    Route::post('admin/add/city-lang', [ApiAdminDataController::class, 'AddCityLang']);
    Route::post('admin/edit/city-lang/{id}', [ApiAdminDataController::class, 'EditCityLang']);

    Route::get('admin/get/subcities/{city_id}', [ApiAdminDataController::class, 'GetSubcities']);
    Route::post('admin/add/subcity', [ApiAdminDataController::class, 'AddSubcity']);
    Route::post('admin/edit/subcity/{id}', [ApiAdminDataController::class, 'EditSubcity']);

    Route::get('admin/get/subcity-langs/{subcity_id}', [ApiAdminDataController::class, 'GetSubcityLangs']);
    Route::post('admin/add/subcity-lang', [ApiAdminDataController::class, 'AddSubcityLang']);
    Route::post('admin/edit/subcity-lang/{id}', [ApiAdminDataController::class, 'EditSubcityLang']);

    Route::get('admin/get/offices', [ApiAdminDataController::class, 'GetOffices']);
    Route::post('admin/add/office', [ApiAdminDataController::class, 'AddOffice']);
    Route::post('admin/edit/office/{id}', [ApiAdminDataController::class, 'EditOffice']);


    Route::get('admin/get/office-subcities/{office_id}', [ApiAdminDataController::class, 'GetOfficeSubcities']);
    Route::post('admin/add/office-subcity', [ApiAdminDataController::class, 'AddOfficeSubcity']);
    Route::post('admin/edit/office-subcity/{id}', [ApiAdminDataController::class, 'EditOfficeSubcity']);



    Route::get('admin/get/languages', [ApiAdminDataController::class, 'GetLanguages']);
    Route::post('admin/add/language', [ApiAdminDataController::class, 'AddLanguage']);
    Route::post('admin/edit/language/{id}', [ApiAdminDataController::class, 'EditLanguage']);


    Route::get('admin/get/brands', [ApiAdminDataController::class, 'GetBrands']);
    Route::post('admin/add/brand', [ApiAdminDataController::class, 'AddBrand']);
    Route::post('admin/edit/brand/{id}', [ApiAdminDataController::class, 'EditBrand']);


    Route::get('admin/get/brand-langs/{brand_id}', [ApiAdminDataController::class, 'GetBrandLangs']);
    Route::post('admin/add/brand-lang', [ApiAdminDataController::class, 'AddBrandLang']);
    Route::post('admin/edit/brand-lang/{id}', [ApiAdminDataController::class, 'EditBrandLang']);

    Route::get('admin/get/goals', [ApiAdminDataController::class, 'GetGoals']);
    Route::post('admin/add/goal', [ApiAdminDataController::class, 'AddGoal']);
    Route::post('admin/edit/goal/{id}', [ApiAdminDataController::class, 'EditGoal']);

    Route::get('admin/get/goal-langs/{goal_id}', [ApiAdminDataController::class, 'GetGoalLangs']);
    Route::post('admin/add/goal-lang', [ApiAdminDataController::class, 'AddGoalLang']);
    Route::post('admin/edit/goal-lang/{id}', [ApiAdminDataController::class, 'EditGoalLang']);

    Route::get('admin/get/tags', [ApiAdminDataController::class, 'GetTags']);
    Route::post('admin/add/tag', [ApiAdminDataController::class, 'AddTag']);
    Route::post('admin/edit/tag/{id}', [ApiAdminDataController::class, 'EditTag']);

    Route::get('admin/get/tag-langs/{tag_id}', [ApiAdminDataController::class, 'GetTagLangs']);
    Route::post('admin/add/tag-lang', [ApiAdminDataController::class, 'AddTagLang']);
    Route::post('admin/edit/tag-lang/{id}', [ApiAdminDataController::class, 'EditTagLang']);


    Route::get('admin/get/sliders', [ApiAdminDataController::class, 'GetSliders']);
    Route::post('admin/add/slider', [ApiAdminDataController::class, 'AddSlider']);
    Route::post('admin/edit/slider/{id}', [ApiAdminDataController::class, 'EditSlider']);

    Route::get('admin/get/slider-langs/{slider_id}', [ApiAdminDataController::class, 'GetSliderLangs']);
    Route::post('admin/add/slider-lang', [ApiAdminDataController::class, 'AddSliderLang']);
    Route::post('admin/edit/slider-lang/{id}', [ApiAdminDataController::class, 'EditSliderLang']);

    Route::get('admin/get/tastes', [ApiAdminDataController::class, 'GetTastes']);
    Route::post('admin/add/taste', [ApiAdminDataController::class, 'AddTaste']);
    Route::post('admin/edit/taste/{id}', [ApiAdminDataController::class, 'EditTaste']);

    Route::get('admin/get/taste-langs/{taste_id}', [ApiAdminDataController::class, 'GetTasteLangs']);
    Route::post('admin/add/taste-lang', [ApiAdminDataController::class, 'AddTasteLang']);
    Route::post('admin/edit/taste-lang/{id}', [ApiAdminDataController::class, 'EditTasteLang']);



    Route::get('admin/get/product-categories', [ApiAdminDataController::class, 'GetProductCategories']);
    Route::post('admin/add/product-category', [ApiAdminDataController::class, 'AddProductCategory']);
    Route::post('admin/edit/product-category/{id}', [ApiAdminDataController::class, 'EditProductCategory']);

    Route::get('admin/get/product-category-langs/{category_id}', [ApiAdminDataController::class, 'GetProductCategoryLangs']);
    Route::post('admin/add/product-category-lang', [ApiAdminDataController::class, 'AddProductCategoryLang']);
    Route::post('admin/edit/product-category-lang/{id}', [ApiAdminDataController::class, 'EditProductCategoryLang']);

    Route::get('admin/get/taxis', [ApiAdminDataController::class, 'GetTaxis']);
    Route::post('admin/add/taxi', [ApiAdminDataController::class, 'AddTaxi']);
    Route::post('admin/edit/taxi/{id}', [ApiAdminDataController::class, 'EditTaxi']);


    Route::get('admin/get/products', [ApiAdminDataController::class, 'GetProducts']);
    Route::get('admin/get/product/{id}', [ApiAdminDataController::class, 'GetProduct']);
    Route::post('admin/add/product', [ApiAdminDataController::class, 'AddProduct']);
    Route::post('admin/edit/product/{id}', [ApiAdminDataController::class, 'EditProduct']);


    Route::post('admin/delete/user/{id}', [ApiAdminDataController::class, 'DeleteUser']);
    Route::get('admin/get/users', [ApiAdminDataController::class, 'GetUsers']);
    Route::get('admin/get/user/{id}', [ApiAdminDataController::class, 'GetUser']);
    Route::post('admin/edit/user/{id}', [ApiAdminDataController::class, 'EditUser']);


    Route::post('admin/delete/guest-user', [ApiAdminDataController::class, 'DeleteGuestUser']);




});
