<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

use Celebgramme\Helpers\GeneralHelper;
use Carbon\Carbon;

use Celebgramme\Models\User;
use Celebgramme\Models\Package;
use Celebgramme\Models\OrderMeta;
// use Illuminate\Database\Eloquent\SoftDeletes;

use Mail;

class Order extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'orders';
	// protected $primaryKey  = "id";
	protected $fillable = [
	];
	// use SoftDeletes;
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
	
	protected function createOrder($cdata,$flag)
	{
        $dt = Carbon::now();
        $coupon_id = 0;$order_discount = 0;
        $coupon = Coupon::where("coupon_code","=",$cdata["coupon_code"])
                    ->where("valid_until",">=",$dt->toDateTimeString())->first();
        if (!is_null($coupon)) {
            $coupon_id = $coupon->id;
						
					if ($coupon->coupon_percent == 0 ) {
						$order_discount = $coupon->coupon_value;
					} else if ($coupon->coupon_value == 0 ) {
						$package = Package::find($cdata["package_manage_id"]);
						$val = floor ( $coupon->coupon_percent / 100 * $package->price );
						$order_discount = $val;
					}
						
        }

				//unique code 
				$unique_code = mt_rand(1, 1000);

        $order = new Order;
    		
    		$str = 'OCLB'.$dt->format('ymdHi');
        $order_number = GeneralHelper::autoGenerateID($order, 'no_order', $str, 3, '0');
        $order->no_order = $order_number;
        $order->order_type = $cdata["order_type"];
        $order->order_status = $cdata["order_status"];
        $order->user_id = $cdata["user_id"];
				if ( $cdata["order_total"] <> 0 ) {
					$order->total = $cdata["order_total"] + $unique_code;
				}
				if ( $cdata["order_total"] == 0 ) {
					$order->total = 0;
				}
        $order->image = "no image, from admin" ;
        $order->discount = $order_discount;
        // $order->package_id = $cdata["package_id"];
        $order->package_id = 0;
        $order->package_manage_id = $cdata["package_manage_id"];
        $order->coupon_id = $coupon_id;
        $order->save();
				
				OrderMeta::createMeta("logs","create order by ".$cdata["logs"],$order->id);

        $user = User::find($cdata["user_id"]);
        $package = Package::find($cdata["package_manage_id"]);
        $shortcode = str_replace('OCLB', '', $order_number);
        //send email order
        $emaildata = [
            'order' => $order,
            'user' => $user,
            'package' => $package,
            'no_order' => $shortcode,
        ];
        if ( $flag ) {
            $emaildata['status'] = "Belum lunas";
        } else {
            $emaildata['status'] = "Lunas";
        }
        Mail::queue('emails.order', $emaildata, function ($message) use ($user,$shortcode) {
          $message->from('no-reply@activfans.com', 'activfans');
          $message->to($user->email);
          $message->subject('[activfans] Order Nomor '.$shortcode);
        });

				
				//send email to admin
				$type_message="[activfans] Order Package";
				$type_message .= "Fullname: ".$user->fullname;
				$emaildata = [
					"user" => $user,
					"status" => "order",
				];
				Mail::queue('emails.info-order-admin', $emaildata, function ($message) use ($type_message) {
					$message->from('no-reply@activfans.com', 'activfans');
					$message->to(array(
						"michaelsugih@gmail.com",
						"celebgramme.dev@gmail.com",
					));
					$message->subject($type_message);
				});
				
        
        return $order;
  }
  
  protected function createNewOrder($cdata) {
    $order = new Order;
    
    $dt = Carbon::now();
    $str = 'OCLB'.$dt->format('ymdHi');
    $order_number = GeneralHelper::autoGenerateID($order, 'no_order', $str, 3, '0');

    $order->no_order = $order_number;
    $order->order_type = 'transfer_bank';
    $order->order_status = 'success';
    $order->user_id = $cdata["user_id"];
    $order->total = $cdata["order_total"];
    $order->image = "no image, from admin" ;
    $order->discount = 0;
    $order->package_id = 0;
    $order->package_manage_id = $cdata["package_manage_id"];
    $order->coupon_id = 0;
    $order->checked = 1;
    $order->type = 'daily-activity';
    $order->is_remind_email = 0;
    $order->added_account = 0;
    $order->save();

    return $order->no_order;
  }
}
