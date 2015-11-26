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
	define('VIEW_IMG_PATH', '/general/images/');
}else{
	define('UPLOADS_PATH', base_path().'/../public_html/general/images/');
	define('VIEW_IMG_PATH', '/general/images/');
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
  
	Route::get('bpv-ranking', 'CronJobController@bpv_ranking');
	Route::get('load-bpv-ranking', 'CronJobController@load_bpv_ranking');
	Route::get('pagination-bpv-ranking', 'CronJobController@pagination_bpv_ranking');
	Route::get('generate-bpv-ranking', 'CronJobController@generate_bpv_ranking');
  
	Route::get('payment', 'Admin\PaymentController@index');
	Route::get('load-payment', 'Admin\PaymentController@load_firstpremi');
	Route::get('pagination-payment', 'Admin\PaymentController@pagination_firstpremi');
	Route::patch('update-payment/{konfirmasiId}', 'Admin\PaymentController@update_firstpremi');
  Route::get('edit-payment', 'Admin\PaymentController@edit');
  Route::post('update-confirm', 'Admin\PaymentController@update_confirm');
  
});
