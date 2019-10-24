<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PurchaseOrderRequestController;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

//Registration Routes
Auth::routes(['verify' => true]);

//PO Routes
Route::resource('/purchase-order-request', 'PurchaseOrderRequestController')->middleware('verified','auth');

//User Routes
Route::resource('/user', 'UserController')->middleware('verified','auth');
Route::resource('/department', 'DepartmentController')->middleware('verified','auth');

//Download PDF
Route::get('/download-pdf/{purchase_order_request}', 'PurchaseOrderRequestController@download_pdf')->name('download.pdf')->middleware('auth');

Route::put('/manager-approve/{purchaseOrderRequest}', 'PurchaseOrderRequestController@manager_approval')->name('manager.approve')->middleware('auth');
Route::put('/senior-manager-approve/{purchaseOrderRequest}', 'PurchaseOrderRequestController@senior_manager_approval')->name('senior-manager.approve')->middleware('auth');
Route::put('/admin-approve/{purchaseOrderRequest}', 'PurchaseOrderRequestController@admin_approval')->name('admin.approve')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified','auth');
Route::get('/create-user', 'UserController@create')->name('create.user')->middleware('verified', 'auth');
Route::post('/save-user', 'UserController@store')->name('store.user')->middleware('verified', 'auth');
Route::get('user-pos/{user}', 'PurchaseOrderRequestController@user_pos')->name('user.pos')->middleware('verified', 'auth');