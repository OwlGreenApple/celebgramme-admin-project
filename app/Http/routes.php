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
	Route::get('verifyemail/{cryptedcode}', 'Auth\RegisterController@verifyEmail');

/*-------------AXIAMARKET/ADMIN----------*/
  Route::get('/', 'Admin\AdminController@index');
  Route::get('home', 'Admin\AdminController@index');
  Route::get('admin', 'Admin\AdminController@index');
  //SUPPLIERS
  Route::get('add-suppliers', array('as'=>'add-suppliers','uses'=>'Admin\SuppliersController@add_suppliers'));
  Route::get('delete-supplier/{supplierId}', array('as'=>'delete-supplier','uses'=>'Admin\SuppliersController@delete_supplier'));
  Route::get('edit-supplier/{supplierId}', array('as'=>'edit-supplier','uses'=>'Admin\SuppliersController@edit_supplier'));
  Route::patch('update-supplier/{supplierId}', array('as'=>'update-supplier','uses'=>'Admin\SuppliersController@update_supplier'));
  Route::post('post-suppliers', array('as'=>'post-suppliers','uses'=>'Admin\SuppliersController@post_suppliers'));
  Route::get('suppliers', array('as'=>'suppliers','uses'=>'Admin\SuppliersController@suppliers'));
  Route::get('load-list-suppliers', array('as'=>'load-list-suppliers','uses'=>'Admin\SuppliersController@load_list_suppliers'));
  
   //Product Categories
  Route::get('add-product-category', array('as'=>'add-product-category','uses'=>'Admin\ProductCategoriesController@add_product_category'));
  Route::get('add-product-category-meta/{productCategoryId}', array('as'=>'add-product-category-meta','uses'=>'Admin\ProductCategoriesController@add_product_category_meta'));
  Route::get('add-sub-product-category/{productCategoryId}', array('as'=>'add-sub-product-category','uses'=>'Admin\ProductCategoriesController@add_sub_product_category'));
  Route::get('delete-product-category/{productCategoryId}', array('as'=>'delete-product-category','uses'=>'Admin\ProductCategoriesController@delete_product_category'));
  Route::get('edit-product-category/{productCategoryId}', array('as'=>'edit-product-category','uses'=>'Admin\ProductCategoriesController@edit_product_category'));
  Route::patch('update-product-category/{productCategoryId}', array('as'=>'update-product-category','uses'=>'Admin\ProductCategoriesController@update_product_category'));
  Route::post('post-product-category', array('as'=>'post-product-category','uses'=>'Admin\ProductCategoriesController@post_product_category'));
  Route::post('post-product-category-meta', array('as'=>'post-product-category-meta','uses'=>'Admin\ProductCategoriesController@post_product_category_meta'));
  Route::get('product-categories', array('as'=>'product-category','uses'=>'Admin\ProductCategoriesController@product_categories'));
  Route::get('load-list-product-categories', array('as'=>'load-list-product-category','uses'=>'Admin\ProductCategoriesController@load_list_product_categories'));
  
  
   //Products
  Route::get('load-list-image', array('as'=>'load-list-image','uses'=>'Admin\ProductsController@load_list_image'));
  Route::get('add-product', array('as'=>'add-product','uses'=>'Admin\ProductsController@add_product'));
  Route::get('add-product-meta/{productId}', array('as'=>'add-product-meta','uses'=>'Admin\ProductsController@add_product_meta'));
  Route::get('delete-product/{productId}', array('as'=>'delete-product','uses'=>'Admin\ProductsController@delete_product'));
  Route::get('delete-product-meta', array('as'=>'delete-product-meta','uses'=>'Admin\ProductsController@delete_product_meta'));
  Route::get('edit-product/{productId}', array('as'=>'edit-product','uses'=>'Admin\ProductsController@edit_product'));
  Route::patch('update-product/{productId}', array('as'=>'update-product','uses'=>'Admin\ProductsController@update_product'));
  Route::post('post-product', array('as'=>'post-product','uses'=>'Admin\ProductsController@post_product'));
  Route::post('post-product-meta', array('as'=>'post-product-meta','uses'=>'Admin\ProductsController@post_product_meta'));
  Route::get('products', array('as'=>'products','uses'=>'Admin\ProductsController@products'));
  Route::get('load-list-products', array('as'=>'load-list-products','uses'=>'Admin\ProductsController@load_list_products'));
  
  //Packages
  Route::get('add-package', array('as'=>'add-package','uses'=>'Admin\PackagesController@add_package'));
  Route::get('add-package-meta/{packageId}', array('as'=>'add-package-meta','uses'=>'Admin\PackagesController@add_package_meta'));
  Route::get('delete-package/{packageId}', array('as'=>'delete-package','uses'=>'Admin\PackagesController@delete_package'));
  Route::get('edit-package/{packageId}', array('as'=>'edit-package','uses'=>'Admin\PackagesController@edit_package'));
  Route::patch('update-package/{packageId}', array('as'=>'update-package','uses'=>'Admin\PackagesController@update_package'));
  Route::post('post-package', array('as'=>'post-package','uses'=>'Admin\PackagesController@post_package'));
  Route::post('post-package-meta', array('as'=>'post-package-meta','uses'=>'Admin\PackagesController@post_package_meta'));
  Route::get('packages', array('as'=>'packages','uses'=>'Admin\PackagesController@packages'));
  Route::get('load-list-packages', array('as'=>'load-list-packages','uses'=>'Admin\PackagesController@load_list_packages'));

  //order
	Route::get('order', array('as'=>'order','uses'=>'Admin\OrderController@order'));
	Route::get('load-order', array('as'=>'order','uses'=>'Admin\OrderController@load_order'));
	Route::get('pagination-order', array('as'=>'order','uses'=>'Admin\OrderController@pagination_order'));
	Route::get('edit-order', array('as'=>'order','uses'=>'Admin\OrderController@edit_order'));
	Route::get('detail-order', array('as'=>'order','uses'=>'Admin\OrderController@detail_order'));
	Route::post('update-order', array('as'=>'order','uses'=>'Admin\OrderController@update_order'));
  
  //invoice
	Route::get('invoice', array('as'=>'order','uses'=>'Admin\InvoiceController@invoice'));
	Route::get('load-invoice', array('as'=>'order','uses'=>'Admin\InvoiceController@load_invoice'));
	Route::get('pagination-invoice', array('as'=>'order','uses'=>'Admin\InvoiceController@pagination_invoice'));
  
  //confirm payment
	Route::get('show-confirm-payment', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@index'));
	Route::get('load-confirm-payment', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@load_confirm_payment'));
	Route::get('pagination-confirm-payment', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@pagination_confirm_payment'));
	Route::post('confirm-payment', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@confirm_payment'));
	Route::get('check-order-confirm', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@check_order_confirm'));
	Route::get('test', array('as'=>'order','uses'=>'Admin\ConfirmPaymentController@test'));

  //settings
  Route::resource('config-global', 'ConfigGlobalController');
	Route::get('load-config-global', 'ConfigGlobalController@load_config_package');
	Route::get('pagination-config-global', 'ConfigGlobalController@pagination_config_package');
  
  
});
