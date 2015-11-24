<?php

namespace Celebgramme\Http\Controllers\Auth;

use Celebgramme\Models\Customer;
use Celebgramme\Models\CustomerMeta;
use Celebgramme\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

use Input, Redirect, App, Hash, Mail, Crypt;

class RegisterController extends Controller
{
	/**
	 * Menampilkan Halaman Register
	 *
	 * @return response
	 */
	public function getRegister(Request $request)
	{
		if ($request->session()->has('register_data')) {
			$request->session()->forget('register_data');
		}
		$user_data = [
			'username' => '',
			'email' => '',
			'customer_name' => '',
			'customer_gender' => 1,
			'customer_hp' => '',
			'social_login' => false,
			'social_token' => '',
		];
		return view('auth/register')->with('user_data', $user_data);
	}
	
	/**
	 * Memproses Data Customer yang mendaftar
	 *
	 * @return response
	 */
	public function postRegister(Request $request)
	{
		$allRequest = $request->all();
		$input = $allRequest['cust'];
		// Google Recaptcha Validation
		$recaptcha_secret = env('GOOGLE_RECAPTCHA_SECRET');
		$recaptcha = new \ReCaptcha\ReCaptcha($recaptcha_secret);
		$resp = $recaptcha->verify($allRequest['g-recaptcha-response'], $request->ip());
		if ($resp->isSuccess()) {
			// Create random username if using Social Button
			$input['social_login'] = false;
			if (isset($allRequest['social_token']) && $allRequest['social_token'] == $request->session()->get('oauth2_token')){
				$input['username'] = $input['customer_name'].rand().rand();
				$input['social_login'] = true;
			}
			// Customer Data Validation
			$validator = Customer::validator($input);
			if (!$validator->fails()){
				$input['random_code'] = rand(100000,999999);
				$request->session()->put('register_data', $input);
				// Send Confirmation Code using Zenziva API then Show Phone Confirmation Page
				$zUserKey = env('ZENZIVA_USERKEY');
				$zPassKey = env('ZENZIVA_PASSKEY');
				$zMessage = 'Thank you for registering at AxiaSmart.com. Here is your confirmation code: '.$input['random_code'];
				$zURL = 'https://reguler.zenziva.net/apps/smsapi.php';
				$curlHandle = curl_init();
				curl_setopt($curlHandle, CURLOPT_URL, $zURL);
				curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$zUserKey.'&passkey='.$zPassKey.'&nohp='.$input['customer_hp'].'&pesan='.urlencode($zMessage));
				curl_setopt($curlHandle, CURLOPT_HEADER, 0);
				curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
				curl_setopt($curlHandle, CURLOPT_POST, 1);
				$results = curl_exec($curlHandle);
				curl_close($curlHandle);
				return redirect('phoneconfirmation');
			}
			else{
				dd($validator->errors()->all());
			}
		} else {
			$errors = $resp->getErrorCodes();
			dd($errors);
		}
	}
	
	/**
	 * Menampilkan Halaman Konfirmasi HP
	 *
	 * @return response
	 */
	public function getPhoneConfirmation(Request $request)
	{
		if ($request->session()->has('register_data')) {
			return view('auth/phoneconfirmation')->with('user_data', $request->session()->get('register_data'));
		}
		else{
			return redirect('register');
		}
	}
	
	/**
	 * Memproses Kode Konfirmasi dan Data Customer Baru
	 *
	 * @return response
	 */
	public function postPhoneConfirmation(Request $request)
	{
		$input = $request->session()->get('register_data');
		$conf_code = $request->input('confirmation_code');
		if ($input['random_code'] == $conf_code){
			$cust = new Customer;
			$cust->username = $input['username'];
			$cust->password = Hash::make($input['password']);
			$cust->email = $input['email'];
			$cust->customer_name = $input['customer_name'];
			$cust->customer_gender = $input['customer_gender'];
			$cust->customer_hp = $input['customer_hp'];
			$cust->reseller_id = 1;
			$cust->status = 'pending';
			$cust->save();
			$register_time = Carbon::now()->toDateTimeString();
			$verificationcode = Hash::make($input['email'].$register_time);
			CustomerMeta::setMeta($cust->id, 'emailverificationcode', $verificationcode);
			$secret_data = [
				'email' => $input['email'],
				'register_time' => $register_time,
				'verification_code' => $verificationcode,
			];
			$emaildata = [
				'name' => $input['customer_name'],
				'url' => 'https://localhost/axiasmart/verifyemail/'.Crypt::encrypt(json_encode($secret_data)),
			];
			Auth::loginUsingId($cust->id);
			Mail::queue('emails.verifyemail', $emaildata, function ($message) use ($input) {
				$message->from('no-reply@axiasmart.com', 'AxiaSmart');
				$message->to($input['email']);
				$message->subject('Verify Email');
			});
			$request->session()->forget('register_data');
			echo 'sukses?';
		}
		else{
			return redirect('phoneconfirmation')->with('error', 'Kode konfirmasi salah!');
		}
	}
	
	public function verifyEmail($cryptedcode)
	{
		if (Auth::check()){
			$go = true;
			try {
				$decryptedcode = Crypt::decrypt($cryptedcode);
				$data = json_decode($decryptedcode);
				$auth = Auth::user();
				$cust = Customer::find($auth->id);
				//Check Email & Status Customer
				if ($auth->email == $data->email && $cust->status != 'verified'){
					$verificationcode = CustomerMeta::getMeta($cust->id, 'emailverificationcode');
					// Check Verification Code
					if ($verificationcode == $data->verification_code){
						$reg_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->register_time);
						// Check Verification Code's Expire Date
						if (Carbon::now()->diffInDays($reg_date) >= 1){
							$go = false;
						}
					}
					else{
						$go = false;
					}
				}
				else{
					$go = false;
				}
			} catch (DecryptException $e) {
				$go = false;
			}
			// If validation pass
			if ($go){
				$cust->status = 'verified';
				$cust->save();
				echo 'verify sukses';
			}
			else{
				echo 'Kode verifikasi salah atau user sudah pernah terverifikasi sebelumnya.';
				// return redirect('register');
			}
		}
		else{
			return redirect('/login');
		}
	}
}
