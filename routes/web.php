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
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes(['verify' => true]);
Route::resource('purchase-order-request', 'PurchaseOrderRequestController');
Route::get('/download-pdf/{purchase_order_request}', 'PurchaseOrderRequestController@download_pdf')->name('download.pdf');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/create-user', 'UserController@create')->name('create.user')->middleware('auth');
Route::post('/save-user', 'UserController@store')->name('store.user')->middleware('auth');