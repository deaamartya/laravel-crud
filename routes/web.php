<?php
Route::get('/login',function(){
	return view('login');
});

Route::get('/',function(){
	return view('home');
});

Route::resource('categories', 'CategoryController');
Route::resource('customer', 'CustomerController');
Route::resource('product', 'ProductController');
Route::resource('sale', 'SaleController');
Route::resource('saledet', 'SaleDetailController');
Route::resource('user', 'UserController');

Route::get('categories/delete/{id}','CategoryController@destroy');
Route::get('customer/delete/{id}','CustomerController@destroy');
Route::get('product/delete/{id}','ProductController@destroy');
Route::get('sale/delete/{id}','SaleController@destroy');
Route::get('user/delete/{id}','UserController@destroy');