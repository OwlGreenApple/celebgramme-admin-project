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
  
	Route::get('payment', 'Admin\PaymentController@index');
	Route::get('load-payment', 'Admin\PaymentController@load_payment');
	Route::get('pagination-payment', 'Admin\PaymentController@pagination_payment');
	Route::patch('update-payment/{konfirmasiId}', 'Admin\PaymentController@update_payment');
  
});
