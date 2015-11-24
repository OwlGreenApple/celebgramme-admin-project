<?php namespace Axiapro\Http\Controllers;

use Axiapro\Models\Tb_admin;

use DB,Request,Auth,Hash;


class LoginController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('auth/login');
	}
	
	public function logout()
	{
		Auth::logout();
		return redirect('login');
	}
	
	public function check_login()
	{
		$username = Request::input('username');
		$pass = Request::input('pass');
		$remember = Request::input('remember');
    if(isset($remember)){
			$remember = true;
		} else {
			$remember = false;
		}

		if (Auth::attempt(['userid' => $username, 'password' => $pass ] , $remember))
		{ 
			return redirect('home');
		}
		else 
		{
            return redirect('login')->withErrors(["msg"=>"Login gagal dengan username: '".$username."' dan password: '".$pass."'. Silahkan coba lagi"]);
		}
			
				
	}

}
