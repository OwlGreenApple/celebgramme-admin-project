<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Products;
use Celebgramme\Models\Meta;

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
            'user' => $admin,
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

	public function update_config(){
		$temp = Meta::createMeta("delay_like_on_same_account",Request::input("delay_like_on_same_account")); //in day
		$temp = Meta::createMeta("number_like_on_same_account",Request::input("number_like_on_same_account")); //in action
		
		$temp = Meta::createMeta("delay_error_cookies_1",Request::input("delay_error_cookies_1"));
		$temp = Meta::createMeta("delay_error_cookies_2",Request::input("delay_error_cookies_2"));
		$temp = Meta::createMeta("delay_error_cookies_3",Request::input("delay_error_cookies_3"));
		$temp = Meta::createMeta("delay_error_cookies_4",Request::input("delay_error_cookies_4"));
		$temp = Meta::createMeta("delay_error_cookies_5",Request::input("delay_error_cookies_5"));
		
		$temp = Meta::createMeta("num_days_comment_same_user",Request::input("num_days_comment_same_user"));
		$temp = Meta::createMeta("num_days_comment_same_media",Request::input("num_days_comment_same_media"));

		$temp = Meta::createMeta("random_delay_follow_slow_min",Request::input("random_delay_follow_slow_min"));
		$temp = Meta::createMeta("random_delay_follow_slow_max",Request::input("random_delay_follow_slow_max"));
		$temp = Meta::createMeta("random_delay_follow_normal_min",Request::input("random_delay_follow_normal_min"));
		$temp = Meta::createMeta("random_delay_follow_normal_max",Request::input("random_delay_follow_normal_max"));
		$temp = Meta::createMeta("random_delay_follow_fast_min",Request::input("random_delay_follow_fast_min"));
		$temp = Meta::createMeta("random_delay_follow_fast_max",Request::input("random_delay_follow_fast_max"));
		
		$temp = Meta::createMeta("random_delay_like_slow_min",Request::input("random_delay_like_slow_min"));
		$temp = Meta::createMeta("random_delay_like_slow_max",Request::input("random_delay_like_slow_max"));
		$temp = Meta::createMeta("random_delay_like_normal_min",Request::input("random_delay_like_normal_min"));
		$temp = Meta::createMeta("random_delay_like_normal_max",Request::input("random_delay_like_normal_max"));
		$temp = Meta::createMeta("random_delay_like_fast_min",Request::input("random_delay_like_fast_min"));
		$temp = Meta::createMeta("random_delay_like_fast_max",Request::input("random_delay_like_fast_max"));
		
		$temp = Meta::createMeta("random_delay_comment_min",Request::input("random_delay_comment_min"));
		$temp = Meta::createMeta("random_delay_comment_max",Request::input("random_delay_comment_max"));
		
		$temp = Meta::createMeta("random_action_follow_slow_min",Request::input("random_action_follow_slow_min"));
		$temp = Meta::createMeta("random_action_follow_slow_max",Request::input("random_action_follow_slow_max"));
		$temp = Meta::createMeta("random_action_follow_normal_min",Request::input("random_action_follow_normal_min"));
		$temp = Meta::createMeta("random_action_follow_normal_max",Request::input("random_action_follow_normal_max"));
		$temp = Meta::createMeta("random_action_follow_fast_min",Request::input("random_action_follow_fast_min"));
		$temp = Meta::createMeta("random_action_follow_fast_max",Request::input("random_action_follow_fast_max"));
		$temp = Meta::createMeta("random_action_follow_turbo_min",Request::input("random_action_follow_turbo_min"));
		$temp = Meta::createMeta("random_action_follow_turbo_max",Request::input("random_action_follow_turbo_max"));
		
		$temp = Meta::createMeta("random_action_like_slow_min",Request::input("random_action_like_slow_min"));
		$temp = Meta::createMeta("random_action_like_slow_max",Request::input("random_action_like_slow_max"));
		$temp = Meta::createMeta("random_action_like_normal_min",Request::input("random_action_like_normal_min"));
		$temp = Meta::createMeta("random_action_like_normal_max",Request::input("random_action_like_normal_max"));
		$temp = Meta::createMeta("random_action_like_fast_min",Request::input("random_action_like_fast_min"));
		$temp = Meta::createMeta("random_action_like_fast_max",Request::input("random_action_like_fast_max"));
		$temp = Meta::createMeta("random_action_like_turbo_min",Request::input("random_action_like_turbo_min"));
		$temp = Meta::createMeta("random_action_like_turbo_max",Request::input("random_action_like_turbo_max"));
		
		$temp = Meta::createMeta("random_action_comment_min",Request::input("random_action_comment_min"));
		$temp = Meta::createMeta("random_action_comment_max",Request::input("random_action_comment_max"));
		
		$temp = Meta::createMeta("random_hourly_limit_follow_slow_min",Request::input("random_hourly_limit_follow_slow_min"));
		$temp = Meta::createMeta("random_hourly_limit_follow_slow_max",Request::input("random_hourly_limit_follow_slow_max"));
		$temp = Meta::createMeta("random_hourly_limit_follow_normal_min",Request::input("random_hourly_limit_follow_normal_min"));
		$temp = Meta::createMeta("random_hourly_limit_follow_normal_max",Request::input("random_hourly_limit_follow_normal_max"));
		$temp = Meta::createMeta("random_hourly_limit_follow_fast_min",Request::input("random_hourly_limit_follow_fast_min"));
		$temp = Meta::createMeta("random_hourly_limit_follow_fast_max",Request::input("random_hourly_limit_follow_fast_max"));
		$temp = Meta::createMeta("random_hourly_limit_follow_turbo_min",Request::input("random_hourly_limit_follow_turbo_min"));
		$temp = Meta::createMeta("random_hourly_limit_follow_turbo_max",Request::input("random_hourly_limit_follow_turbo_max"));
		
		$temp = Meta::createMeta("random_hourly_limit_like_slow_min",Request::input("random_hourly_limit_like_slow_min"));
		$temp = Meta::createMeta("random_hourly_limit_like_slow_max",Request::input("random_hourly_limit_like_slow_max"));
		$temp = Meta::createMeta("random_hourly_limit_like_normal_min",Request::input("random_hourly_limit_like_normal_min"));
		$temp = Meta::createMeta("random_hourly_limit_like_normal_max",Request::input("random_hourly_limit_like_normal_max"));
		$temp = Meta::createMeta("random_hourly_limit_like_fast_min",Request::input("random_hourly_limit_like_fast_min"));
		$temp = Meta::createMeta("random_hourly_limit_like_fast_max",Request::input("random_hourly_limit_like_fast_max"));
		
		$temp = Meta::createMeta("random_hourly_limit_comment_min",Request::input("random_hourly_limit_comment_min"));
		$temp = Meta::createMeta("random_hourly_limit_comment_max",Request::input("random_hourly_limit_comment_max"));

		$temp = Meta::createMeta("daily_follow_slow_limit_min",Request::input("daily_follow_slow_limit_min"));
		$temp = Meta::createMeta("daily_follow_slow_limit_max",Request::input("daily_follow_slow_limit_max"));
		$temp = Meta::createMeta("daily_follow_normal_limit_min",Request::input("daily_follow_normal_limit_min"));
		$temp = Meta::createMeta("daily_follow_normal_limit_max",Request::input("daily_follow_normal_limit_max"));
		$temp = Meta::createMeta("daily_follow_fast_limit_min",Request::input("daily_follow_fast_limit_min"));
		$temp = Meta::createMeta("daily_follow_fast_limit_max",Request::input("daily_follow_fast_limit_max"));
		
		$temp = Meta::createMeta("daily_like_slow_limit_min",Request::input("daily_like_slow_limit_min"));
		$temp = Meta::createMeta("daily_like_slow_limit_max",Request::input("daily_like_slow_limit_max"));
		$temp = Meta::createMeta("daily_like_normal_limit_min",Request::input("daily_like_normal_limit_min"));
		$temp = Meta::createMeta("daily_like_normal_limit_max",Request::input("daily_like_normal_limit_max"));
		$temp = Meta::createMeta("daily_like_fast_limit_min",Request::input("daily_like_fast_limit_min"));
		$temp = Meta::createMeta("daily_like_fast_limit_max",Request::input("daily_like_fast_limit_max"));

		$temp = Meta::createMeta("daily_comment_limit_min",Request::input("daily_comment_limit_min"));
		$temp = Meta::createMeta("daily_comment_limit_max",Request::input("daily_comment_limit_max"));
		
		
		$temp = Meta::createMeta("delay_antara_action_follow_min",Request::input("delay_antara_action_follow_min"));
		$temp = Meta::createMeta("delay_antara_action_follow_max",Request::input("delay_antara_action_follow_max"));
		$temp = Meta::createMeta("delay_antara_action_like_min",Request::input("delay_antara_action_like_min"));
		$temp = Meta::createMeta("delay_antara_action_like_max",Request::input("delay_antara_action_like_max"));
		$temp = Meta::createMeta("delay_antara_action_comment_min",Request::input("delay_antara_action_comment_min"));
		$temp = Meta::createMeta("delay_antara_action_comment_max",Request::input("delay_antara_action_comment_max"));

		$temp = Meta::createMeta("daily_follow_turbo_limit_min",Request::input("daily_follow_turbo_limit_min"));
		$temp = Meta::createMeta("daily_follow_turbo_limit_max",Request::input("daily_follow_turbo_limit_max"));
		$temp = Meta::createMeta("daily_like_turbo_limit_min",Request::input("daily_like_turbo_limit_min"));
		$temp = Meta::createMeta("daily_like_turbo_limit_max",Request::input("daily_like_turbo_limit_max"));
		

		$temp = Meta::createMeta("check_account_auto_like_min",Request::input("check_account_auto_like_min")); 
		$temp = Meta::createMeta("check_account_auto_like_max",Request::input("check_account_auto_like_max")); 
		$temp = Meta::createMeta("minute_check_auto_like_min",Request::input("minute_check_auto_like_min")); 
		$temp = Meta::createMeta("minute_check_auto_like_max",Request::input("minute_check_auto_like_max")); 
		$temp = Meta::createMeta("minute_check_auto_like_celebfans_min",Request::input("minute_check_auto_like_celebfans_min")); 
		$temp = Meta::createMeta("minute_check_auto_like_celebfans_max",Request::input("minute_check_auto_like_celebfans_max")); 
		
    //$temp = Meta::createMeta("promo_referral",Request::input("promo_referral")); 
    $temp = Meta::createMeta("bonus_referral",Request::input("bonus_referral")); 

		return "success";
	}
}
