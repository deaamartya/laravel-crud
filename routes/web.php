<?php
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

Route::get('login','UserController@login');
Route::get('logout','UserController@logout');
Route::post('login/verify','UserController@verify');

Route::get('/home', function(){
	return view('dashboard');
});

Route::get('/','UserController@login');