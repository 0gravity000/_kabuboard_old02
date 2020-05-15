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
Route::get('/realtime', 'RealtimeController@index');
Route::get('/realtime/create', 'RealtimeController@create');
Route::post('/realtime/store', 'RealtimeController@store');
Route::get('/realtime/destroy/{user_id}/{code_id}', 'RealtimeController@destroy');
