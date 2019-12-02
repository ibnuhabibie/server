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

Route::get('/', function ()
{
    return view()->make('welcome');
});

Route::get('share/{share}', 'ShareController@show')->name('share.show');
Route::delete('share/{share}', 'ShareController@delete')->name('share.delete');
