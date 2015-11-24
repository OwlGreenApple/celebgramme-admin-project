<?php

namespace Celebgramme\Http\Controllers;

use Celebgramme\Models\Product;
use Celebgramme\Models\ProductMeta;
use Illuminate\Http\Request;
use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Auth;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */	
	public function index()
	{
			//
	}

	/**
	 * Display the detail of the Product.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showDetail($product_id, $product_slug = '')
	{
		$prod_data = Product::where('products.id', '=', $product_id)
												->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_categories_id')
												->leftJoin('suppliers', 'suppliers.id', '=', 'products.supplier_id')
												->firstOrFail();
		return view('products.detailproduct')->with('prod_data', $prod_data);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
			//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
			//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
			//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
			//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
			//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			//
	}
}
