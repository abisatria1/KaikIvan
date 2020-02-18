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

// login
Route::get('/login' , 'LoginController@show');
Route::post('/login' , 'LoginController@login');
Route::get('/createManager' , 'LoginController@createUser');
Route::get('/logout' , 'LoginController@logout');

Route::get('/', 'OrdersController@index' );
Route::get('/input', 'OrdersController@create' );
Route::post('/input', 'OrdersController@store' );
Route::delete('/{order}' , 'OrdersController@destroy');
Route::put('/{order}' , 'OrdersCOntroller@update');


Route::get('/jasa' , 'JasaController@index');
Route::delete('/jasa/{jasa}' , 'JasaController@destroy');
Route::put('jasa/{jasa}' , 'JasaCOntroller@update');
Route::get('/jasa/input' , 'JasaController@create');
Route::post('jasa/show/{jasa}' , 'KomisiController@store');
Route::get('/jasa/show/{jasa}' , 'JasaController@show');
Route::get('/jasa/showAll/{jasa}/{bulan}' , 'JasaController@allOrderByMonth');
Route::get('/jasa/showAll/{jasa}' , 'JasaController@allOrder');
Route::post('/jasa' , 'JasaController@store');
Route::get('jasa/show/{jasa}/{tanggal}' , 'JasaController@showByDate');
Route::put('jasa/show/{jasa}/{order}' , 'JasaController@updateKomisi');
Route::get('jasa/getRiwayat' , 'JasaController@getRiwayatBayar');


Route::get('/sopir' , 'SopirController@index');
Route::get('/sopir/input' , 'SopirController@create');
Route::post('/sopir' , 'SopirController@store');
Route::delete('/sopir/{sopir}' , 'SopirController@destroy');
Route::put('/sopir/{sopir}' , 'SopirController@update');
Route::get('/sopir/show/{sopir}' , 'SopirController@show');
Route::get('/sopir/show' , 'SopirController@showByDate');
Route::post('/sopir/validasi' , 'SopirController@validasiOrder');
Route::get('/sopir/showAll/{sopir}/{date}' , 'SopirController@orderBulanan');
Route::get('/sopir/showAll/{sopir}' , 'SopirController@allOrder');


Route::get('/getSopir' , 'SopirController@getSopir');
Route::get('/getSopirOrder/{kode_sopir}' , 'SopirController@getDataSopir');