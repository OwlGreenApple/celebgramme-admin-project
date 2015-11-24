<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Suppliers;
use Celebgramme\Models\Product_categories;
use Celebgramme\Models\Packages;
use Celebgramme\Models\Package_features;
use Celebgramme\Models\Admin_logs_axs;
use Celebgramme\Models\Product_metas;
use Celebgramme\Models\Products;

use Celebgramme\Http\Requests\ImageRequest;
use Celebgramme\Http\Requests\ProductRequest;
use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config;

class AdminController extends Controller {
    
	public function index(){
    $admin = Auth::user();
		return view('admin.index')->with(
           array(
            'admin' => $admin,
           ));
	}
}
