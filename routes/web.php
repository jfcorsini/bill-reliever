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

Route::get('/user/{user}', 'UserController@show');

Route::post('/member', 'MemberController@store');

Route::group([], function () {
    Route::get('group', 'GroupController@index');
    Route::get('group/create', 'GroupController@create');
    Route::post('group', 'GroupController@store');
    Route::get('group/{group}', 'GroupController@show');
    Route::get('group/{group}/edit', 'GroupController@edit'); // Not implemented yet
    Route::put('group/{group}', 'GroupController@update'); // Not implemented yet
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('payment/create', 'PaymentController@create');
    Route::post('payment', 'PaymentController@store');
    Route::post('payment/split', 'PaymentController@split');
    Route::delete('payment/{payment}', 'PaymentController@destroy');
});

Route::get('bill/{bill}', 'BillController@show');
Route::get('transaction/{transaction}/pay', 'TransactionController@pay')
    ->middleware('auth');
