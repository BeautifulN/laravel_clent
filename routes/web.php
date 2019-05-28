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


//APP
Route::post('register', 'Login\RegController@register');  //APP注册
Route::post('log', 'Login\LogController@log');  //APP登录
Route::post('goodsall', 'Goods\GoodsallController@goodsall');  //APP商品展示
Route::post('content', 'Goods\GoodsallController@content');  //APP商品详情
Route::post('cart', 'Goods\GoodsallController@cart');  //APP购物车
Route::post('cartlist', 'Goods\GoodsallController@cartlist');  //APP购物车展示
Route::post('order', 'Goods\GoodsallController@order');  //APP订单生成
Route::post('order_detail', 'Goods\GoodsallController@order_detail');  //APP订单展示
Route::get('pay', 'Pay\PayController@pay');  //APP订单展示
Route::get('test', 'Pay\PayController@test');  //APP订单展示


//API系统   accessToken
Route::get('license', 'Admin\RegController@license');  //API审核展示
Route::post('license_do', 'Admin\RegController@license_do');  //API审核
Route::get('apireg_list', 'Admin\RegController@apireg_list');  //API注册展示
Route::post('apireg', 'Admin\RegController@apireg');  //API注册执行
Route::post('accessToken', 'Admin\RegController@accessToken')->Middleware('token');  //API生成token
Route::get('token', 'Admin\RegController@token');  //API
Route::post('ip', 'Admin\RegController@ip');  //获取ip


Route::get('sign', 'Login\SignController@sign');  //签到
Route::post('sign_do', 'Login\SignController@sign_do');  //签到
Route::get('sign_doo', 'Login\SignController@sign_doo');  //签到





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
