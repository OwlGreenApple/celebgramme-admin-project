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
  Route::post('update-password', 'Admin\AdminController@update_password');
  
	Route::get('post', 'Admin\PostController@index');
	Route::get('load-post', 'Admin\PostController@load_post');
	Route::get('pagination-post', 'Admin\PostController@pagination_post');
	Route::patch('update-post/{konfirmasiId}', 'Admin\PostController@update_post');
  
	/* Post auto manage */
	Route::get('create-excel/{string}/{stringby}', 'Admin\PostController@create_excel');
	Route::get('post-auto-manage', 'Admin\PostController@auto_manage');
	Route::get('load-post-auto-manage', 'Admin\PostController@load_auto_manage');
	Route::get('pagination-post-auto-manage', 'Admin\PostController@pagination_auto_manage');
	Route::patch('update-auto-manage/{id}', 'Admin\PostController@update_auto_manage');
	Route::patch('update-error-cred/{id}', 'Admin\PostController@update_error_cred');
	Route::post('update-fl-filename', 'Admin\PostController@update_fl_filename');
	Route::get('download-all/{setting_id}', 'Admin\PostController@create_excel_all');
	Route::get('download-hashtags/{setting_id}/{stringby}', 'Admin\PostController@create_excel_hashtags');
	Route::get('download-usernames/{setting_id}/{stringby}', 'Admin\PostController@create_excel_usernames');
	Route::get('download-comments/{setting_id}', 'Admin\PostController@create_excel_comments');

	/* Setting */
	Route::get('setting', 'Admin\SettingController@index');
	Route::get('load-setting', 'Admin\SettingController@load_setting');
	Route::get('pagination-setting', 'Admin\SettingController@pagination_setting');
	
	/* Meta */
	/* Follow liker name file list */
	Route::get('fl-name', 'Admin\MetaController@fl_name');
	Route::get('load-fl-name', 'Admin\MetaController@load_fl_name');
	Route::get('pagination-fl-name', 'Admin\MetaController@pagination_fl_name');
	Route::post('add-meta-fl', 'Admin\MetaController@add_fl');
	Route::post('delete-meta-fl', 'Admin\MetaController@delete_fl');

	Route::get('access-token', 'Admin\MemberController@access_token');
	Route::get('load-access-token', 'Admin\MemberController@load_access_token');
	Route::get('pagination-access-token', 'Admin\MemberController@pagination_access_token');
	Route::post('update-access-token', 'Admin\MemberController@update_access_token');

	/* Member */
	Route::get('member-all', 'Admin\MemberController@member_all');
	Route::get('load-member-all', 'Admin\MemberController@load_member_all');
	Route::get('pagination-member-all', 'Admin\MemberController@pagination_member_all');
	Route::post('give-bonus', 'Admin\MemberController@give_bonus');
	Route::post('add-member', 'Admin\MemberController@add_member');
	Route::post('edit-member', 'Admin\MemberController@edit_member');
	Route::post('delete-member', 'Admin\MemberController@delete_member');

	/* Coupon */
	Route::get('coupon', 'Admin\PaymentController@coupon');
	Route::get('load-coupon', 'Admin\PaymentController@load_coupon');
	Route::get('pagination-coupon', 'Admin\PaymentController@pagination_coupon');
	Route::post('process-coupon', 'Admin\PaymentController@process_coupon');

	/* Order */
	Route::get('order', 'Admin\PaymentController@order');
	Route::get('load-order', 'Admin\PaymentController@load_order');
	Route::get('pagination-order', 'Admin\PaymentController@pagination_order');
	Route::post('add-order', 'Admin\PaymentController@add_order');
	Route::post('delete-order', 'Admin\PaymentController@delete_order');
	
	/* Package auto manage */
	Route::get('package-auto-manage', 'Admin\PackageController@package_auto_manage');
	Route::get('load-package-auto-manage', 'Admin\PackageController@load_package_auto_manage');
	Route::get('pagination-package-auto-manage', 'Admin\PackageController@pagination_package_auto_manage');
	Route::post('add-package-auto-manage', 'Admin\PackageController@add_package');
	Route::post('delete-package-auto-manage', 'Admin\PackageController@delete_package');
	
	/* Confirm Payment */
	Route::get('payment', 'Admin\PaymentController@index');
	Route::get('load-payment', 'Admin\PaymentController@load_payment');
	Route::get('pagination-payment', 'Admin\PaymentController@pagination_payment');
	Route::patch('update-payment/{konfirmasiId}', 'Admin\PaymentController@update_payment');
  
	Route::get('invoice', 'Admin\InvoiceController@index');
	Route::get('load-invoice', 'Admin\InvoiceController@load_invoice');
	Route::get('pagination-invoice', 'Admin\InvoiceController@pagination_invoice');
});
