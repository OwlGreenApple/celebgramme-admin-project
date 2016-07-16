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
  Route::post('update-password', 'Admin\AdminController@update_password');
  Route::post('update-config', 'Admin\AdminController@update_config');
  
	Route::get('post', 'Admin\PostController@index');
	Route::get('load-post', 'Admin\PostController@load_post');
	Route::get('pagination-post', 'Admin\PostController@pagination_post');
	Route::patch('update-post/{konfirmasiId}', 'Admin\PostController@update_post');
  
	/* Post auto manage */
	Route::get('create-excel/{string}/{stringby}/{username}', 'Admin\PostController@create_excel');
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
	Route::patch('update-status-admin/{id}', 'Admin\PostController@update_status_admin');
	Route::post('send-email-member', 'Admin\PostController@send_email_member');
	Route::get('load-template', 'Admin\PostController@load_template_email');

	/* Meta */
	/* Follow spiderman name file list */
	Route::get('fl-name', 'Admin\MetaController@fl_name');
	Route::get('load-fl-name', 'Admin\MetaController@load_fl_name');
	Route::get('pagination-fl-name', 'Admin\MetaController@pagination_fl_name');
	Route::post('add-meta-fl', 'Admin\MetaController@add_fl');
	Route::post('delete-meta-fl', 'Admin\MetaController@delete_fl');

	/* templates email list */
	Route::get('template-email', 'Admin\MetaController@template_email');
	Route::get('load-template-email', 'Admin\MetaController@load_template_email');
	Route::get('pagination-template-email', 'Admin\MetaController@pagination_template_email');
	Route::post('add-template-email', 'Admin\MetaController@add_template_email');
	Route::post('delete-template-email', 'Admin\MetaController@delete_template_email');

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
	Route::post('edit-member-login-webstame', 'Admin\MemberController@edit_member_login_webstame');
	Route::post('edit-member-max-account', 'Admin\MemberController@edit_member_max_account');
	Route::get('home-page', 'Admin\MemberController@home_page');
	Route::post('save-home-page', 'Admin\MemberController@save_home_page');

	/* Coupon */
	Route::get('coupon', 'Admin\PaymentController@coupon');
	Route::get('load-coupon', 'Admin\PaymentController@load_coupon');
	Route::get('pagination-coupon', 'Admin\PaymentController@pagination_coupon');
	Route::post('process-coupon', 'Admin\PaymentController@process_coupon');
	Route::post('process-setting-coupon', 'Admin\PaymentController@process_setting_coupon');

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
  
	/* Setting Account IG All*/
	Route::get('setting', 'Admin\SettingController@index');
	Route::get('setting/{search}', 'Admin\SettingController@index');
	Route::get('load-setting', 'Admin\SettingController@load_setting');
	Route::get('pagination-setting', 'Admin\SettingController@pagination_setting');
	Route::post('update-status-server', 'Admin\SettingController@update_status_server');
	Route::post('update-setting-proxy', 'Admin\SettingController@update_setting_proxy');
	Route::post('update-method-automation', 'Admin\SettingController@update_method_automation');
	Route::post('update-server-automation', 'Admin\SettingController@update_server_automation');
	Route::post('refresh-automation-IG-account', 'Admin\SettingController@refresh_account');
	Route::post('refresh-auth-IG-account', 'Admin\SettingController@refresh_auth');
	
	/* Status Setting Account IG Automation*/
	Route::get('setting-automation', 'Admin\SettingController@automation');
	Route::get('setting-automation/{search}', 'Admin\SettingController@automation');
	Route::get('load-automation', 'Admin\SettingController@load_automation');
	Route::get('pagination-automation', 'Admin\SettingController@pagination_automation');
	Route::get('load-automation-logs', 'Admin\SettingController@get_logs_automation');
	Route::get('load-automation-logs-daily', 'Admin\SettingController@get_logs_automation_daily');
	Route::get('load-automation-logs-hourly', 'Admin\SettingController@get_logs_automation_hourly');
	Route::get('load-automation-logs-error', 'Admin\SettingController@get_logs_automation_error');
	
	/* Daily Setting Account IG Automation*/
	Route::get('setting-automation-daily', 'Admin\SettingController@automation_daily');
	Route::get('setting-automation-daily/{search}', 'Admin\SettingController@automation_daily');
	Route::get('load-automation-daily', 'Admin\SettingController@load_automation_daily');
	Route::get('pagination-automation-daily', 'Admin\SettingController@pagination_automation_daily');
	
	/* Proxy Manager  */
	Route::get('proxy-manager', 'Admin\ProxyController@index');
	Route::get('load-proxy-manager', 'Admin\ProxyController@load_proxy_manager');
	Route::get('pagination-proxy-manager', 'Admin\ProxyController@pagination_proxy_manager');
	Route::post('add-proxy', 'Admin\ProxyController@add_proxy');
	Route::post('delete-proxy', 'Admin\ProxyController@delete_proxy');
	
	/* Email  */
	Route::get('email-users', 'Admin\EmailController@index');
	Route::get('load-email-users', 'Admin\EmailController@load_email_users');
	Route::get('pagination-email-users', 'Admin\EmailController@pagination_email_users');
	Route::post('add-email-users', 'Admin\EmailController@add_email_users');
	Route::post('edit-email-users', 'Admin\EmailController@edit_email_users');
	Route::post('delete-email-users', 'Admin\EmailController@delete_email_users');
	Route::get('blast-email', 'Admin\EmailController@blast_email');
	Route::post('send-blast-email', 'Admin\EmailController@send_blast_email');

	Route::get('invoice', 'Admin\InvoiceController@index');
	Route::get('load-invoice', 'Admin\InvoiceController@load_invoice');
	Route::get('pagination-invoice', 'Admin\InvoiceController@pagination_invoice');

	/* Admin */
	Route::get('admin', 'Admin\MemberController@admin');
	Route::get('load-admin', 'Admin\MemberController@load_admin');
	Route::get('pagination-admin', 'Admin\MemberController@pagination_admin');
	Route::post('add-admin', 'Admin\MemberController@add_admin');
	Route::post('edit-admin', 'Admin\MemberController@edit_admin');
	Route::post('delete-admin', 'Admin\MemberController@delete_admin');
	
	/* Log Post */
	Route::get('log-post', 'Admin\PostController@log_post');
	Route::get('load-log-post', 'Admin\PostController@load_log_post');
	Route::get('pagination-log-post', 'Admin\PostController@pagination_log_post');
	
	
});
