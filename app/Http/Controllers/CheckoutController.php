<?php

namespace Celebgramme\Http\Controllers;

use Celebgramme\Models\Product;
use Celebgramme\Models\ProductMeta;
use Illuminate\Http\Request;
use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Auth;

class CheckoutController extends Controller
{
	/**
	 * Product add to cart
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function addToCart(Request $request)
	{
		// setcookie('cart', 'asd', time()-60);exit;
		if (isset($_COOKIE['cart'])){
			$cart = json_decode($_COOKIE['cart'], true);
		}
		else{
			$cart = [];
		}
		$prod_data = Product::where('products.id', '=', $request->input('pid'))
												->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_categories_id')
												->leftJoin('suppliers', 'suppliers.id', '=', 'products.supplier_id')
												->first();
		if ($prod_data == null){
			return redirect('404');
			echo 'item-not-found';
		}
		else{
			if (array_get($cart, $request->input('pid')) == null){
				$cart[$request->input('pid')] = $request->input('qty');
			}
			else{
				$cart[$request->input('pid')] = $cart[$request->input('pid')]+$request->input('qty');
			}
			setcookie('cart', json_encode($cart), strtotime('+5 years'), '/');
		}
		return back();
	}
	
	/**
	 * Ajax Get Shopping Cart Product Count
	 *
	 * @return string
	 */
	public function getCartCount()
	{
		if (isset($_COOKIE['cart'])){
			$cart = count(json_decode($_COOKIE['cart'], true));
		}
		else{
			$cart = 0;
		}
		return $cart;
	}
	
	/**
	 * Show Customer Cart Detail
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cartIndex()
	{
		if (isset($_COOKIE['cart'])){
			$cart = json_decode($_COOKIE['cart'], true);
			$cart_data = [];
			foreach ($cart as $key => $value){
				$prod_data = Product::where('products.id', '=', $key)
														->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_categories_id')
														->leftJoin('suppliers', 'suppliers.id', '=', 'products.supplier_id')
														->first();
				array_push($cart_data, [
					'product' => $prod_data,
					'qty' => $value,
				]);
			}
		}
		else{
			$cart_data = [];
		}
		return view('products.cart')->with('cart_data', $cart_data);
	}
	
	/**
	 * Ajax Change Product Qty on Shopping Cart
	 *
	 * @return string
	 */
	public function changeCartQty(Request $request)
	{
		$cart = json_decode($_COOKIE['cart'], true);
		$pid = $request->input('pid');
		$qty = $request->input('qty');
		if (isset($cart[$pid])){
			if ($qty == 0){
				unset($cart[$pid]);
			}
			else{
				$cart[$pid] = $qty;
			}
		}
		setcookie('cart', json_encode($cart), strtotime('+5 years'), '/');
		return 'success';
	}
	
	/**
	 * Show Checkout Login Page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function checkoutLogin()
	{
		if (isset($_COOKIE['cart'])){
			$cart = json_decode($_COOKIE['cart'], true);
			if (count($cart) == 0){
				return redirect('cart');
			}
			else{
				if (Auth::check()){
					return redirect('checkout/shippinginformation');
				}
				else{
					$cart = json_decode($_COOKIE['cart'], true);
					$cart_data = [];
					foreach ($cart as $key => $value){
						$prod_data = Product::where('products.id', '=', $key)
																->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_categories_id')
																->leftJoin('suppliers', 'suppliers.id', '=', 'products.supplier_id')
																->first();
						array_push($cart_data, [
							'product' => $prod_data,
							'qty' => $value,
						]);
					}
					return view('checkout.login')->with('cart_data', $cart_data);
				}
			}
		}
		else{
			return redirect('cart');
		}
	}
	
	/**
	 * Show Checkout Shipping Information page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function checkoutShippingInformation()
	{
		if (isset($_COOKIE['cart'])){
			$cart = json_decode($_COOKIE['cart'], true);
			if (count($cart) == 0){
				return redirect('cart');
			}
			else{
				if (Auth::check()){
					$cart = json_decode($_COOKIE['cart'], true);
					$cart_data = [];
					foreach ($cart as $key => $value){
						$prod_data = Product::where('products.id', '=', $key)
																->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_categories_id')
																->leftJoin('suppliers', 'suppliers.id', '=', 'products.supplier_id')
																->first();
						array_push($cart_data, [
							'product' => $prod_data,
							'qty' => $value,
						]);
					}
					return view('checkout.shippinginformation')->with('cart_data', $cart_data);
				}
				else{
					return redirect('checkout/login');
				}
			}
		}
		else{
			return redirect('cart');
		}
	}
}
