<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Products;

use Celebgramme\Http\Requests\ImageRequest;
use Celebgramme\Http\Requests\ProductRequest;
use Illuminate\Http\Request as req;

use View,Auth,Request,DB,Carbon,Excel,Input,Config,Validator,Hash;

class AdminController extends Controller {
    
	public function index(){
    $admin = Auth::user();
		return view('admin.index')->with(
           array(
            'admin' => $admin,
           ));
	}
	
	public function update_password(){
		$admin = Auth::user();
		$data = Input::all();
		$rules = array(
				'old_password' => 'required',
				'new_password' => 'required|confirmed',
				'new_password_confirmation' => 'required'
		);

		// Create a new validator instance.
		$validator = Validator::make($data, $rules);

		if (!Auth::validate(array('email' => Auth::user()->email, 'password' => Input::get('old_password')))) {
				return "error";
		}

		if ($validator->fails()) {
				return "error";
		}              

		//Storing the data to the database         
		$admin->password = Input::get('new_password');
		if ($admin->save()) {
			return "success";
		}		
	}
}
