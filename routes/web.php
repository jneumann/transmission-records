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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/product', 'ProductView@index')->middleware('auth');
Route::get('/order', 'OrderView@index');
Route::get('/order/purchase_order', 'OrderView@purchase_order');
Route::get('/order/label', 'OrderView@label');
