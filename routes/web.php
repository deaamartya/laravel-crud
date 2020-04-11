<?php
Route::resource('categories', 'CategoryController');
Route::resource('customer', 'CustomerController');
Route::resource('product', 'ProductController');
Route::resource('sale', 'SaleController');
Route::resource('saledet', 'SaleDetailController');
Route::resource('user', 'UserController');

Route::get('categories/getdata', 'CategoryController@getCategory')->name('categories.getdata');

Route::get('categories/delete/{id}','CategoryController@destroy');
Route::get('categories/restore/{id}','CategoryController@restore');

Route::get('customer/delete/{id}','CustomerController@destroy');
Route::get('product/delete/{id}','ProductController@destroy');
Route::get('product/restore/{id}','ProductController@restore');

Route::get('sale/delete/{id}','SaleController@destroy');
Route::get('user/delete/{id}','UserController@destroy');

Route::get('categories/updateStatus/{id}','CategoryController@updateStatus');
Route::get('customer/updateStatus/{id}','CustomerController@updateStatus');

Route::get('login','UserController@login');
Route::get('logout','UserController@logout');
Route::post('login/verify','UserController@verify');

Route::get('/home', function(){
	return view('dashboard');
});

Route::get('/index', function(){
	return view('index');
});

Route::get('/testAjax','IndexController@index');
Route::post('/testAjax/getProduct','IndexController@getProduct');

Route::get('/','UserController@login');
