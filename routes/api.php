<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Must uncomment line-29 in App\Providers\App\Providers to use following namespace

Route::group([
    'namespace' => 'API',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});

Route::group([
    'middleware' => ['auth:api', 'role:admin'],
    'namespace' => 'API\Admin',
    'prefix' => 'admin'

], function () {
    // Admin Home Controller
    Route::get('orders-overview', 'HomeController@ordersOverview');

    // Admin User Controller
    Route::get('users', 'UserController@users');
    Route::post('add-user', 'UserController@AddUser');
    Route::post('update-user/{id}', 'UserController@updateUser');
    Route::post('update-password/{id}', 'UserController@updatePassword');
    Route::delete('delete-user/{id}', 'UserController@deleteUser');

    // Admin Orders Controller
    Route::get('orders', 'OrderController@getAllOrders');
    Route::get('mark-order-as-complete/{orderId}', 'OrderController@markOrderAsCompleted');
    Route::delete('orders/{orderId}', 'OrderController@DeleteOrder');
    Route::post('update-order-status/{orderId}', 'OrderController@updateOrderStatus');
    Route::get('get-all-completed-orders', 'OrderController@getCompletedOrders');

    // Admin Item Controller
    Route::get('items', 'ItemController@getAllItems');
    Route::post('add-item', 'ItemController@addItem');
    Route::post('update-item/{id}', 'ItemController@updateItem');
    Route::delete('delete-item/{id}', 'ItemController@deleteItem');

    // Admin Excel Controller
    Route::post('upload-file', "ExcelController@importDataToDatabase");

});

