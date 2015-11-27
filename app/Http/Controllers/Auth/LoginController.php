<?php

namespace Celebgramme\Http\Controllers\Auth;

use Celebgramme\Http\Controllers\Controller;
use Celebgramme\Models\Customer;
use Illuminate\Http\Request;
use Celebgramme\Http\Requests\LoginFormRequest as loginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;

use Input, Redirect, App, Socialite;
class LoginController extends Controller
{
	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}
	
	/**
	 * Menampilkan halaman login
	 *
	 * @return response
	 */
	public function getLogin()
	{
		if (Auth::check()){
			return Redirect('/');
		}
		else{
			return view('auth/login');
		}
	}
	
	/**
	 * login kedalam aplikasi
	 *
	 * var loginRequest $request
	 *
	 * @return response
	 */
	public function postLogin(loginRequest $request)
	{
		$remember = (Input::has('remember')) ? true : false;
		if (Auth::attempt(['email' => $request->username, 'password' => $request->password, "type"=>"admin",], $remember)) {
			if (isset($request->r)){
				return redirect($request->r);
			}
			else{
				return redirect('/');
			}
		} else {
			return Redirect::to('/login')
				->withInput(Input::except('password'));
		}
	}
	
	/**
	 * logout
	 *
	 *
	 * @return response
	 */
	public function getLogout(Request $request)
	{
		$request->session()->flush();
		Auth::logout();
		return Redirect('/login');
	}
	
	/**
	 * Show Socialite authentication page
	 *
	 *
	 * @return response
	 */
	public function redirectToProvider(Request $request, $provider)
	{
		if (isset($request->r)){
			$request->session()->put('redirect_url', $request->r);
		}
		return Socialite::driver($provider)->redirect();
	}
	
	public function handleProviderCallback(Request $request, $provider)
	{
		$user = Socialite::driver($provider)->user();
		$cust = Customer::where('email', '=', $user->email)->first();
		if ($cust == null){
			// IF NOT REGISTERED YET
			$user_data = [
				'username' => '',
				'email' => $user->getEmail(),
				'customer_name' => $user->getName(),
				'customer_gender' => 1,
				'customer_hp' => '',
				'social_login' => true,
				'social_token' => $user->token,
			];
			
			$request->session()->put('oauth2_token', $user->token);
			return view('auth/register')->with('user_data', $user_data);
		}
		else{
			// ELSE REGISTERED ALREADY
			Auth::loginUsingId($cust->id);
			return redirect('/home');
		}
	}
}
