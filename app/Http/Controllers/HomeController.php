<?php

namespace Celebgramme\Http\Controllers;

/*Models*/
use Celebgramme\Models\Supplier;
use Celebgramme\Models\Member;

use Celebgramme\Http\Controllers\Controller;
use Celebgramme\Http\Requests\loginFormRequest as loginRequest;
use Illuminate\Support\Facades\Auth;use Hash;
class HomeController extends Controller
{
	/**
	 * Menampilkan halaman utama
	 *
	 * @return response
	 */
	public function index(){
		$suppliers = Supplier::get();
		return view('welcome',compact('suppliers'));
	}
	
	
	
}
