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
    Route::get('inventory-overview', 'HomeController@inventoryOverview');

    // Admin User Controller
    Route::get('users', 'UserController@users');
    Route::post('add-user', 'UserController@AddUser');
    Route::post('update-user/{id}', 'UserController@updateUser');
    Route::post('update-password/{id}', 'UserController@updatePassword');
    Route::delete('delete-user/{id}', 'UserController@deleteUser');
    Route::get('change-user-status/{id}', 'UserController@changeUserStatus');

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

    // Admin Inventory Controller
    Route::get('inventory-list', 'InventoryController@getAllInventory');   
    Route::post('add-inventory', 'InventoryController@addNewInventoryItem'); 
    Route::post('update-inventory/{id}', 'InventoryController@updateInventoryItem'); 
    Route::delete('delete-inventory/{id}', 'InventoryController@deleteInventoryItem'); 

    // Admin Purchase Controller
    Route::get('purchases', 'PurchaseController@getAllPurchases');   
    Route::post('add-new-purchase', 'PurchaseController@addNewPurchase'); 
    Route::post('update-purchase/{id}', 'PurchaseController@updatePurchaseItem'); 
    Route::delete('delete-purchase/{id}', 'PurchaseController@deletePurchaseItem');     

    // Admin Excel Controller
    Route::post('upload-file', "ExcelController@importDataToDatabase");

    // Admin ScanQRCode Controller
    Route::get('getAllStatuses', 'ScanQRCodeController@getAllStatuses');    
    Route::get('getOrder/{orderNo}', 'ScanQRCodeController@getOrder');
    Route::post('updateOrderList', 'ScanQRCodeController@updateOrderList');
    Route::get('getItem/{itemCode}', 'ScanQRCodeController@getItem');
    Route::post('updateItemsList', 'ScanQRCodeController@updateItemsList');

    // Admin DailyExpense Controller
    Route::get('daily-expense', 'DailyExpenseController@getAllExpenses');
    Route::post('add-expense', 'DailyExpenseController@addExpense');
    Route::delete('delete-expense/{id}', 'DailyExpenseController@deleteExpense');


    // Admin Logs Controller
    Route::get('logs', 'LogsController@getLogs');

    // Admin Revenue Controller
    Route::get('revenues', 'RevenueController@getRevenues');

});

Route::group([
    'middleware' => ['auth:api', 'role:employee'],
    'namespace' => 'API\Employee',
    'prefix' => 'employee'

], function () {
    // Employee Home Controller
    Route::get('orders-overview', 'HomeController@ordersOverview');
    Route::get('inventory-overview', 'HomeController@inventoryOverview');

    // Employee User Controller
    Route::post('update-password/{id}', 'UserController@updatePassword');

    // Employee Orders Controller
    Route::get('orders', 'OrderController@getAllOrders');
    Route::get('mark-order-as-complete/{orderId}', 'OrderController@markOrderAsCompleted');
    Route::delete('orders/{orderId}', 'OrderController@DeleteOrder');
    Route::post('update-order-status/{orderId}', 'OrderController@updateOrderStatus');
    Route::get('get-all-completed-orders', 'OrderController@getCompletedOrders');

    // Employee Item Controller
    Route::get('items', 'ItemController@getAllItems');    

    // Employee Inventory Controller
    Route::get('inventory-list', 'InventoryController@getAllInventory');   
    Route::post('add-inventory', 'InventoryController@addNewInventoryItem'); 
    Route::post('update-inventory/{id}', 'InventoryController@updateInventoryItem'); 
    Route::delete('delete-inventory/{id}', 'InventoryController@deleteInventoryItem');   

    // Employee Excel Controller
    Route::post('upload-file', "ExcelController@importDataToDatabase");

    // Employee ScanQRCode Controller
    Route::get('getAllStatuses', 'ScanQRCodeController@getAllStatuses');    
    Route::get('getOrder/{orderNo}', 'ScanQRCodeController@getOrder');
    Route::post('updateOrderList', 'ScanQRCodeController@updateOrderList');
    Route::get('getItem/{itemCode}', 'ScanQRCodeController@getItem');
    Route::post('updateItemsList', 'ScanQRCodeController@updateItemsList');    

});

Route::group([
    'namespace' => 'API\Auth'

], function () {

    Route::post('/userForgotPassword', 'ForgotPasswordController@userForgotPassword');
    Route::post('/resetPassword', 'ForgotPasswordController@resetPassword');

});

