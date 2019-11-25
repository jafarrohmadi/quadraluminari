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
});

Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/pendaftaran', 'HomeController@pendaftaran')->name('pendaftaran');

	Route::get('item','ItemController@index');
	Route::get('item/create','ItemController@create');
	Route::post('item/store', 'ItemController@store');
	Route::get('item/edit/{id}', 'ItemController@edit');
	Route::put('item/update/{id}', 'ItemController@update');
	Route::get('item/delete/{id}', 'ItemController@delete');

	Route::get('users','UserController@index');
	Route::get('users/create','UserController@create');
	Route::post('users/store', 'UserController@store');
	Route::get('users/edit/{id}', 'UserController@edit');
	Route::put('users/update/{id}', 'UserController@update');
	Route::get('users/delete/{id}', 'UserController@delete');

	Route::get('transactions', 'TransactionsController@create');
	Route::post('transactions/store', 'TransactionsController@store');
