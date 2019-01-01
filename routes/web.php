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

Route::get('',[
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
]);

Route::get('loai-san-pham/{type}',[
	'as'=>'loaisanpham',
	'uses'=>'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{id}',[
	'as'=>'chitietsanpham',
	'uses'=>'PageController@getChitietSp'
]);

Route::get('lien-he',[
	'as'=>'lienhe',
	'uses'=>'PageController@getLienhe'
]);

Route::get('thong-tin',[
	'as'=>'thongtin',
	'uses'=>'PageController@getThongtin'
]);

Route::get('add-to-cart/{id}',[
	'as'=>'themgiohang',
	'uses'=>'PageController@getAddtoCart'
]);

// Route::get('add-to-cart-qty/{id}',[
// 	'as'=>'themgiohang_sl',
// 	'uses'=>'PageController@getAddtoCartwithQty'
// ]);

Route::post('add-to-cart-qty',[
	'as'=>'themgiohang_sl',
	'uses'=>'PageController@postAddtoCartwithQty'
]);

Route::get('del-cart/{id}',[
	'as'=>'xoagiohang',
	'uses'=>'PageController@getDelItemCart'
]);

Route::get('thanh-toan',[
	'as'=>'thanhtoan',
	'uses'=>'PageController@getThanhtoan'
]);

Route::post('thanh-toan',[
	'as'=>'thanhtoan',
	'uses'=>'PageController@postThanhtoan'
]);

Route::get('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@getLogin'
]);

Route::post('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@postLogin'
]);

Route::get('dang-xuat',[
	'as'=>'logout',
	'uses'=>'PageController@getLogout'
]);

Route::get('dang-ky',[
	'as'=>'signup',
	'uses'=>'PageController@getSignUp'
]);

Route::post('dang-ky',[
	'as'=>'signup',
	'uses'=>'PageController@postSignUp'
]);

Route::get('sua-thong-tin',[
	'as'=>'update_info',
	'uses'=>'PageController@getUpdateInfo'
]);

Route::post('sua-thong-tin',[
	'as'=>'update_info',
	'uses'=>'PageController@postUpdateInfo'
]);


Route::get('search',[
	'as'=>'search',
	'uses'=>'PageController@getSearch'
]);

Route::get('doi-mat-khau',[
	'as'=>'changepass',
	'uses'=>'PageController@getChangePass'
]);

Route::post('doi-mat-khau',[
	'as'=>'changepass',
	'uses'=>'PageController@postChangePass'
]);