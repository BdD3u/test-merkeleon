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

Route::get('/balance', [
    'uses' => 'UserBalanceController@actionGetBalance',
    'as' => 'balance',
]);

Route::post('/deposit', [
    'uses' => 'UserBalanceController@actionDeposit',
    'as' => 'deposit',
]);

Route::post('/withdraw', [
    'uses' => 'UserBalanceController@actionWithdraw',
    'as' => 'withdraw',
]);

Route::post('/transfer', [
    'uses' => 'UserBalanceController@actionTransfer',
    'as' => 'transfer',
]);
