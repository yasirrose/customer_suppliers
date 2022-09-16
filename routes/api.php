<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [API\LoginController::class, 'login']);

Route::post('register', [API\RegisterController::class, 'register']);
// Route::post('logout','UserController@logoutApi');
// Route::post('logout', [API\LoginController::class, 'logoutApi']);
Route::middleware('token')->group(function () {
    Route::post('logout', [API\LoginController::class, 'logout']); 
});

    
Route::group(['prefix' => 'admin',  'middleware' => 'token'], function(){

    Route::get('getAdminInfo', [API\AdminController::class, 'getAdminInfo']); 
    Route::post('updateAdminInfo', [API\AdminController::class, 'updateAdminInfo']); 
    Route::post('updatePassword', [API\AdminController::class, 'updatePassword']); 
    Route::post('updateEmail', [API\AdminController::class, 'updateEmail']);
    Route::get('getUserLogs', [API\AdminController::class, 'getUserLogs']);
    Route::get('getAppLinks', [API\AdminController::class, 'getAppLinks']);
    
    
    
    // my routes
    Route::get('getPermissions/{user_level}', [API\AdminController::class, 'getPermissions']);
    Route::get('getRelUsers/{user_level}', [API\AdminController::class, 'getRelUsers']);
    Route::post('createUser', [API\AdminController::class, 'createUser']);
    Route::get('getUsers', [API\AdminController::class, 'getUsers']);
    Route::post('saveOrder', [API\AdminController::class, 'saveOrder']);
    Route::get('getOrders/{user_id}/{user_level}', [API\AdminController::class, 'getOrders']);
   
    Route::post('UpdateUserInfo', [API\AdminController::class, 'UpdateUserInfo']);
    Route::get('getWarehouseDetail/{user_id}', [API\AdminController::class, 'getWarehouseDetail']);
    Route::post('addWarehouseDetail', [API\AdminController::class, 'addWarehouseDetail']);
    Route::post('addProductType', [API\AdminController::class, 'addProductType']);
    Route::post('addProduct', [API\AdminController::class, 'addProduct']);
    Route::get('getProductTypes', [API\AdminController::class, 'getProductTypes']);
    Route::get('getAllProducts', [API\AdminController::class, 'getAllProducts']);
    Route::get('getAllCurrencies', [API\AdminController::class, 'getAllCurrencies']);
    Route::get('getProfileInfo', [API\AdminController::class, 'getProfileInfo']);
    Route::post('updateProfileInfo', [API\AdminController::class, 'updateProfileInfo']);
    Route::get('getSingleProduct/{product_id}', [API\AdminController::class, 'getSingleProduct']);
    Route::post('updateProduct', [API\AdminController::class, 'updateProduct']);
    Route::get('getSingleOrder/{order_id}', [API\AdminController::class, 'getSingleOrder']);
    Route::get('getUserDetail/{user_id}', [API\AdminController::class, 'getUserDetail']);
    Route::get('getUserLevels/{user_id}', [API\AdminController::class, 'getUserLevels']);
    
    Route::get('getAllUserLevels', [API\AdminController::class, 'getAllUserLevels']);
    Route::get('getWarehouse/{warehouse_id}', [API\AdminController::class, 'getWarehouse']);
    Route::post('UpdateWarehouse', [API\AdminController::class, 'UpdateWarehouse']);

    });
    
    Route::get('getAllRoles', [API\AdminController::class, 'getAllRoles']);

Route::group(['prefix' => 'client',  'middleware' => 'token'], function(){
    
});