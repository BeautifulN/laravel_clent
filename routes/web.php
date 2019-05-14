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



Route::get('lists', 'Dome\SslController@lists');
Route::post('ssl', 'Dome\SslController@ssl');  //对称加密
Route::post('keys', 'Dome\SslController@keys');  //非对称加密


Route::get('regindex', 'Login\RegController@regindex');  //注册展示
Route::post('reg', 'Login\RegController@reg');  //用户注册

Route::get('qian', 'Dome\SslController@qian');