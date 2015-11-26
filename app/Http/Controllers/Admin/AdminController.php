<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

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
