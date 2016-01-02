<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

if(\App::environment() == "local"){
	//D:\xampp\htdocs\general\images\products
	define('UPLOADS_PATH', base_path().'/../htdocs/general/images/');
	define('VIEW_IMG_PATH', url('').'/../general/images/');
}else{
	define('UPLOADS_PATH', base_path().'/../public_html/general/images/');
	define('VIEW_IMG_PATH', url('').'/../general/images/');
}
/*--------- Login routes ---------*/
Route::get('login', 'Auth\LoginController@getLogin');
Route::post('auth/login', ['as'=>'auth.login', 'uses'=> 'Auth\LoginController@postLogin']);
Route::get('auth/logout', 'Auth\LoginController@getLogout');
Route::get('auth/{provider}/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

/*--------- Must Login Routes ---------*/
Route::group(['middleware' => 'auth'], function()
{
  
  Route::get('/', 'Admin\AdminController@index');
  Route::get('home', 'Admin\AdminController@index');
  Route::get('admin', 'Admin\AdminController@index');
  
	Route::get('post', 'Admin\PostController@index');
	Route::get('load-post', 'Admin\PostController@load_post');
	Route::get('pagination-post', 'Admin\PostController@pagination_post');
	Route::patch('update-post/{konfirmasiId}', 'Admin\PostController@update_post');
  
	Route::get('post-auto-manage', 'Admin\PostController@auto_manage');
	Route::get('load-post-auto-manage', 'Admin\PostController@load_auto_manage');
	Route::get('pagination-post-auto-manage', 'Admin\PostController@pagination_auto_manage');
	Route::patch('update-auto-manage/{id}', 'Admin\PostController@update_auto_manage');
	Route::patch('update-error-cred/{id}', 'Admin\PostController@update_error_cred');

	Route::get('access-token', 'Admin\MemberController@access_token');
	Route::get('load-access-token', 'Admin\MemberController@load_access_token');
	Route::get('pagination-access-token', 'Admin\MemberController@pagination_access_token');
	Route::post('update-access-token', 'Admin\MemberController@update_access_token');

	Route::get('member-all', 'Admin\MemberController@member_all');
	Route::get('load-member-all', 'Admin\MemberController@load_member_all');
	Route::get('pagination-member-all', 'Admin\MemberController@pagination_member_all');
	Route::post('give-bonus', 'Admin\MemberController@give_bonus');
	Route::post('add-member', 'Admin\MemberController@add_member');

	Route::get('coupon', 'Admin\PaymentController@coupon');
	Route::get('load-coupon', 'Admin\PaymentController@load_coupon');
	Route::get('pagination-coupon', 'Admin\PaymentController@pagination_coupon');
	Route::post('process-coupon', 'Admin\PaymentController@process_coupon');

	Route::get('payment', 'Admin\PaymentController@index');
	Route::get('load-payment', 'Admin\PaymentController@load_payment');
	Route::get('pagination-payment', 'Admin\PaymentController@pagination_payment');
	Route::patch('update-payment/{konfirmasiId}', 'Admin\PaymentController@update_payment');
  
	Route::get('invoice', 'Admin\InvoiceController@index');
	Route::get('load-invoice', 'Admin\InvoiceController@load_invoice');
	Route::get('pagination-invoice', 'Admin\InvoiceController@pagination_invoice');
});
