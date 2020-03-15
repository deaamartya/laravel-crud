<?php
Route::get('/',function(){
	return view('home');
});
Route::resource('categories', 'CategoryController');
Route::resource('customer', 'CustomerController');
Route::resource('product', 'ProductController');
Route::resource('sale', 'SaleController');
Route::resource('saledet', 'SaleDetailController');
Route::resource('user', 'UserController');

Route::get('saledet/createid/{id}','SaleDetailController@createid');
Route::post('saledet/store/{id}','SaleDetailController@insert');
Route::get('saledet/destroy/{nota_id}/{product_id}','SaleDetailController@destroy');
Route::get('/saledet/edit/{nota_id}/{product_id}','SaleDetailController@edit');
Route::post('/saledet/update/{nota_id}/{product_id}','SaleDetailController@update');