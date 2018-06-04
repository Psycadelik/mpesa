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

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('/registerurl', 'MpesaTransactionsController@Register');
Route::any('/simulate', 'MpesaTransactionsController@SimulateTransaction');
Route::any('/validate','MpesaTransactionsController@c2bValidate');
Route::any('/response', 'MpesaTransactionsController@SimulateTransactionResponse');