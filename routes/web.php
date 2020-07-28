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
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

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
Route::get('admin/', function(){
	return redirect('admin/dangnhap');
});
Route::get('admin/dangnhap','AdminController@getdangnhapAdmin');
Route::post('admin/dangnhap','AdminController@postdangnhapAdmin');

Route::get('admin/logout','AdminController@getDangxuatAdmin');

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	Route::group(['prefix'=>'loaisanpham'],function(){
		//admin/loaisanpham/them
		Route::get('danhsach','AdminController@getDanhSachLoaiSp');

		Route::get('sua/{id}','AdminController@getSuaLoaiSp');
		Route::post('sua/{id}','AdminController@postSuaLoaiSp');

		Route::get('them','AdminController@getThemLoaiSp');
		Route::post('them','AdminController@postThemLoaiSp');

		Route::get('xoa/{id}','AdminController@getXoaLoaiSp');

		Route::post('ajaxLoaisanpham', 'AdminController@ajaxLoaisanphamStatus');
	});
	Route::group(['prefix'=>'sanpham'],function(){
		//admin/sanpham/them
		Route::get('danhsach','AdminController@getDanhSachSp');

		Route::get('sua/{id}','AdminController@getSuaSp');
		Route::post('sua/{id}','AdminController@postSuaSp');

		Route::get('them','AdminController@getThemSp');
		Route::post('them','AdminController@postThemSp');

		Route::get('xoa/{id}','AdminController@getXoaSp');
	});
	Route::group(['prefix'=>'donhang'],function(){
		//admin/donhang/them
		Route::get('danhsach','AdminController@getDanhSachDonhang');

		Route::get('sua/{id}','AdminController@getSuaDonhang');
		Route::post('sua/{id}','AdminController@postSuaDonhang');

		Route::get('them','AdminController@getThemDonhang');
		Route::post('them','AdminController@postThemDonhang');

		Route::get('xoa/{id}','AdminController@getXoaDonhang');

		Route::post('ajaxRequest', 'AdminController@ajaxRequestStatus');
	});

	// Route::group(['prefix'=>'loaitin'],function(){
	// 	//admin/theloai/them
	// 	Route::get('danhsach','LoaiTinController@getDanhSach');

	// 	Route::get('sua/{id}','LoaiTinController@getSua');
	// 	Route::post('sua/{id}','LoaiTinController@postSua');

	// 	Route::get('them','LoaiTinController@getThem');
	// 	Route::post('them','LoaiTinController@postThem');

	// 	Route::get('xoa/{id}','LoaiTinController@getXoa');
	// });
	// Route::group(['prefix'=>'tintuc'],function(){
	// 	//admin/theloai/them
	// 	Route::get('danhsach','TinTucController@getDanhSach');

	// 	Route::get('sua/{id}','TinTucController@getSua');
	// 	Route::post('sua/{id}','TinTucController@postSua');

	// 	Route::get('them','TinTucController@getThem');
	// 	Route::post('them','TinTucController@postThem');

	// 	Route::get('xoa/{id}','TinTucController@getXoa');


	// });
	// Route::group(['prefix'=>'comment'],function(){
	// 	Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');	
	// });
	// Route::group(['prefix'=>'ajax'],function(){
	// 	Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
	// });
	// Route::group(['prefix'=>'user'],function(){
	// 	//admin/theloai/them
	// 	Route::get('danhsach','UserController@getDanhSach');

	// 	Route::get('sua/{id}','UserController@getSua');
	// 	Route::post('sua/{id}','UserController@postSua');

	// 	Route::get('xoa/{id}','UserController@getXoa');
	// 	Route::post('xoa/{id}','UserController@postXoa');

	// 	Route::get('them','UserController@getThem');
	// 	Route::post('them','UserController@postThem');
	// });
	// Route::group(['prefix'=>'slide'],function(){
	// 	//admin/theloai/them
	// 	Route::get('danhsach','SlideController@getDanhSach');

	// 	Route::get('sua/{id}','SlideController@getSua');
	// 	Route::post('sua/{id}','SlideController@postSua');

	// 	Route::get('them','SlideController@getThem');
	// 	Route::post('them','SlideController@postThem');

	// 	Route::get('xoa/{id}','SlideController@getXoa');
	});