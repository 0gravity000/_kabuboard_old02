<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/meigara', 'MeigaraController@index');
Route::get('/meigara/import', 'MeigaraController@import');
Route::get('/realtime_checking', 'RealtimeController@index_checking');
Route::get('/realtime_setting', 'RealtimeController@index_setting');
Route::get('/realtime/create', 'RealtimeController@create');
Route::post('/realtime/store', 'RealtimeController@store');
Route::get('/realtime/destroy/{user_id}/{stock_id}', 'RealtimeController@destroy');
Route::get('/realtime/edit/{user_id}/{stock_id}', 'RealtimeController@edit');
Route::get('/realtime/update_checking', 'RealtimeController@update_checking');
Route::post('/realtime/update_setting', 'RealtimeController@update_setting');
Route::get('/realtime_history', 'RealtimeController@index_history');
