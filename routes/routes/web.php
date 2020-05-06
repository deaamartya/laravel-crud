<?php
Route::resource('categories', 'CategoryController');
Route::resource('customer', 'CustomerController');
Route::resource('product', 'ProductController');
Route::resource('sale', 'SaleController');
Route::resource('saledet', 'SaleDetailController');
Route::resource('user', 'UserController');
Route::get('product/filterbyCat/{id}','ProductController@filterbyCat');
Route::get('customer/getData/{id}','CustomerController@getData');

Route::get('getEarning/{tahun}','SaleController@getEarnings');
Route::get('getTopSell','SaleController@getTopSell');
Route::get('getInfoSale','SaleController@getInfoSale');
Route::get('getEarningBulan/{month}','SaleController@getEarningBulan');


Route::post('sale/create/step1','SaleController@storeStep1');

Route::get('sale/create/step2','SaleController@createStep2');
Route::get('sale/edit/step1','SaleController@editStep1');
// Route::post('sale/create/step2','SaleController@storeStep2');

Route::get('categories/getdata', 'CategoryController@getCategory')->name('categories.getdata');

Route::get('categories/delete/{id}','CategoryController@destroy');
Route::get('customer/delete/{id}','CustomerController@destroy');
Route::get('product/delete/{id}','ProductController@destroy');
Route::get('user/delete/{id}','UserController@destroy');

Route::get('product/restore/{id}','ProductController@restore');
Route::get('categories/restore/{id}','CategoryController@restore');
Route::get('customer/restore/{id}','CustomerController@restore');
Route::get('user/restore/{id}','UserController@restore');

Route::get('categories/updateStatus/{id}','CategoryController@updateStatus');
Route::get('customer/updateStatus/{id}','CustomerController@updateStatus');

Route::get('login','UserController@login');
Route::get('logout','UserController@logout');
Route::post('login/verify','UserController@verify');

Route::get('/home', 'IndexController@index');

Route::get('/testAjax','IndexController@index');
Route::post('/testAjax/getProduct','IndexController@getProduct');

Route::get('/','UserController@login');
Route::get('/sales/print-pdf','SaleController@printPDF');