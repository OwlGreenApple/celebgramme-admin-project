<?php namespace Celebgramme\Models;

use Celebgramme\Models\Setting;
use Celebgramme\Models\CouponRule;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Validator;

class Coupon extends Model {

	/**
	 * untuk koneksi ke database utama
	 *
	 * @var string
	 */
	protected $connection = 'mysql_axs';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'coupons';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['coupon_code','owner_id','referral_id','valid_until','status','no_order'];
	public 		$timestamps = true;
	
	protected function createCoupon($coupon_value, $coupon_type, $owner_id, $referral_id, $description)
	{
		$dt = Carbon::now();
		$valid_days = intval(Setting::getValue('coupon_valid_days'));
		
		$coupon = new Coupon;
		$coupon->coupon_code = uniqid(); // Temporary unique code
		$coupon->coupon_value = $coupon_value;
		$coupon->coupon_type = $coupon_type;
		$coupon->owner_id = $owner_id;
		$coupon->referral_id = $referral_id;
		$coupon->coupon_description = $description;
		$coupon->valid_until = $dt->addDays($valid_days);
		$coupon->status = 'unused';
		$coupon->no_order = '';
		$coupon->save();
	}
	
	protected function checkCouponExpired($owner_id)
	{
		$coupons = Coupon::where('owner_id', '=', $owner_id)
										 ->where('status', '=', 'unused')
										 ->get();
		foreach ($coupons as $coupon){
			$valid_date = Carbon::createFromFormat('Y-m-d H:i:s', $coupon->valid_until);
			$valid_date = $valid_date->addDay();
			if ($valid_date->isPast()){
				$coupon->update(['status' => 'expired']);
			}
		}
	}
	
	protected function getCustomerCoupons($owner_id, $total)
	{
		// Check and set coupon expired
		// $this->checkCouponExpired($owner_id);
		// Get Customer's available coupon
		$allcoupons = [];
		$crules = CouponRule::all();
		foreach ($crules as $rule){
			$limit = floor( $total / $rule->min_price );
			$coupons = Coupon::select('coupons.coupon_code','coupons.coupon_value','coupon_rules.min_price')
											 ->leftJoin('coupon_rules', 'coupon_rules.max_coupon_value', '=', 'coupons.coupon_value')
											 ->where('coupons.owner_id', '=', $owner_id)
											 ->where('coupons.status', '=', 'unused')
											 ->where('coupons.coupon_value', '=', $rule->max_coupon_value)
											 ->take($limit)
											 ->get();
			foreach ($coupons as $coupon){
				array_push($allcoupons, $coupon);
			}
		}
		return $allcoupons;
	}
}
