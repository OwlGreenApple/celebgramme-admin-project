<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Invoice;
use Celebgramme\Models\Order;
use Celebgramme\Models\User;
use Celebgramme\Models\Package;
use Celebgramme\Models\PackageUser;
use Celebgramme\Models\Coupon;
use Celebgramme\Models\Meta;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator;

class PaymentController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show 1stpremi page.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();
		return View::make('admin.confirm.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_payment()
  {
		/*
		* status 
		* 2 = All
		* 1 = confirmed
		* 0 = Not confirmed
		*/
		
    if (Request::input('status')==0) { $temp_s = "="; }
    if (Request::input('status')==1) { $temp_s = "<>"; }
    if (Request::input('search')=="") {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s, "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
							 ->where('orders.order_status','<>',"cron dari affiliate")
               ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s,"")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    }

    $user = Auth::user();
    return view('admin.confirm.content')->with(
                array(
                  'user'=>$user,
                  'order'=>$order,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_payment()
  {
		/*
		* status 
		* 2 = All
		* 1 = confirmed
		* 0 = Not confirmed
		*/
		
    if (Request::input('status')==1) { $temp_s = "<>"; }
    if (Request::input('status')==0) { $temp_s = "="; }
    if (Request::input('search')=="") {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s, "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
							 ->where('orders.order_status','<>',"cron dari affiliate")
               ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s,"")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    }

    return view('admin.confirm.pagination')->with(
                array(
                  'order'=>$order,
                ));
  }

	public function update_payment($konfirmasiId)
  {
    $order = Order::find($konfirmasiId);
    $order->order_status = "success";
    $order->checked = true;
    $order->save();
    
    $user = User::find($order->user_id);
    $user->status_auto_manage = "member";
      
    // klo beli paket daily likes
    $package = Package::find($order->package_id);
    if (!is_null($package)) {
      $packageuser = new PackageUser;
      $packageuser->package_id = $order->package_id;
      $packageuser->user_id = $order->user_id;
      $packageuser->save();

      $user->balance = $package->daily_likes;
      
      $dt = Carbon::createFromFormat('Y-m-d H:i:s', $user->valid_until);
      $dt2 = Carbon::now();
      if ($dt2->gt($dt)) {
        $dt = $dt2;
      }
      if ($package->package_type=="day") {
        $user->valid_until = $dt->addDays(1)->toDateTimeString();
      }
      if ($package->package_type=="week") {
        $user->valid_until = $dt->addDays(7)->toDateTimeString();
      }
      if ($package->package_type=="month") {
        $user->valid_until = $dt->addDays(28)->toDateTimeString();
      }
      $user->status_free_trial = 0;
      $user->save();
    }
    
    // klo beli paket auto manage
    $package = Package::find($order->package_manage_id);
    if (!is_null($package)) {
      $packageuser = new PackageUser;
      $packageuser->package_id = $order->package_manage_id;
      $packageuser->user_id = $order->user_id;
      $packageuser->save();

      $user->active_auto_manage += $package->active_days * 86400;
			$user->max_account = $package->max_account;
      $user->save();
    }

		$coupon = Coupon::find($order->coupon_id);
		$coupon_value = 0 ;
		if (!is_null($coupon)) {
			$coupon_value = $coupon->coupon_value;
		}
		
    //create invoice
    $invoice = new Invoice;

		$dt = Carbon::now();
		$str = 'ICLB'.$dt->format('ymdHi');
    $invoice_number = GeneralHelper::autoGenerateID($invoice, 'no_invoice', $str, 3, '0');

    $invoice->no_invoice = $invoice_number;
    $invoice->total = $order->total - $coupon_value;
    $invoice->order_id = $order->id;
    $invoice->save();
    
    $shortcode = str_replace('ICLB', '', $invoice_number);
    $emaildata = [
        'no_invoice' => $shortcode,
        'package' => $package,
        'invoice' => $invoice,
        'order' => $order,
        'coupon_value' => $coupon_value,
    ];
    if ($order->order_type=="transfer_bank") {
        $emaildata["order_type"] = "Transfer Bank";
    }
    if ($order->order_type=="VERITRANS") {
        $emaildata["order_type"] = "Veritrans";
    }
    Mail::queue('emails.success-payment', $emaildata, function ($message) use ($user) {
      $message->from('no-reply@celebgramme.com', 'Celebgramme');
      $message->to($user->email);
      $message->subject('[Celebgramme] Success Payment');
    });

    return "success";
  }






/*
* Coupon
*
*/


  /**
   * Show Coupon page.
   *
   * @return Response
   */
  public function coupon()
  {
    $user = Auth::user();
		$packages = Package::where("package_group","=","auto-manage")->get();

    return View::make('admin.coupon.index')->with(
                  array(
                    'user'=>$user,
                    'packages'=>$packages,
                  ));
  }

  public function load_coupon()
  {
    $arr = Coupon::paginate(15);

    return view('admin.coupon.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_coupon()
  {
    $arr = Coupon::paginate(15);
    
                              
    return view('admin.coupon.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function process_coupon()
  {
    if (Request::input("id-coupon")=="new") {
      $coupon = new Coupon;
    } else {
      $coupon = Coupon::find(Request::input("id-coupon"));
    }
    $coupon->coupon_code = Request::input("coupon_code");
    $coupon->coupon_value = Request::input("coupon_value");
    $coupon->valid_until = date("Y-m-d", intval(Request::input('valid_until')));
    $coupon->coupon_percent = Request::input("coupon_percentage");
    $coupon->package_id = Request::input("coupon_package_id");
    $coupon->save();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }

  public function process_setting_coupon()
  {
		$meta = Meta::createMeta("coupon_setting_days",Request::input("coupon_setting_days"));
		$meta = Meta::createMeta("coupon_setting_value",Request::input("coupon_setting_value"));
		$meta = Meta::createMeta("coupon_setting_percentage",Request::input("coupon_setting_percentage"));
		$meta = Meta::createMeta("coupon_setting_package_id",Request::input("coupon_setting_package_id"));

    $arr['type'] = 'success';
    return $arr;    
	}


/*
* Order
*
*/


  /**
   * Show Order page.
   *
   * @return Response
   */
  public function order()
  {
    $user = Auth::user();
		if ( ($user->email == "it2.axiapro@gmail.com") || ($user->email == "admin@admin.com") ) {
			$packages_affiliate = Package::
														where("package_group","=","auto-manage")
														;

			return View::make('admin.order.index')->with(
										array(
											'user'=>$user,
											'packages_affiliate'=>$packages_affiliate,
										));
		} else {
			return "NOT authorized";
		}
  }

  public function load_order()
  {
		if (Request::input('keyword') == "" ) {
			$arr = Order::orderBy('id', 'desc')->paginate(15);
		} else {
			$arr = Order::leftJoin("users","users.id","=","orders.user_id")
							->where("no_order","like","%".Request::input('keyword')."%")
							->orWhere("email","like","%".Request::input('keyword')."%")
							->orWhere("fullname","like","%".Request::input('keyword')."%")
							->orderBy('orders.id', 'desc')->paginate(15);
		}

    return view('admin.order.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_order()
  {
    $arr = Order::orderBy('id', 'desc')->paginate(15);
    
                              
    return view('admin.order.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function add_order()
  {
		$dt = Carbon::now();
		if (Request::input("id-order")=="new") {
			$arr["message"] = "Proses add order berhasil dilakukan";
			$data = array (
				"email" => Request::input("email"),
			);
			$validator = Validator::make($data, [
				'email' => 'required|email|max:255|unique:users',
			]);
			if ($validator->fails()){
				$arr["type"] = "error";
				$arr["message"] = "Email sudah terdaftar atau tidak valid";
				return $arr;
			}
			
      $order = new Order;
			$str = 'OCLB'.$dt->format('ymdHi');
			$order_number = GeneralHelper::autoGenerateID($order, 'no_order', $str, 3, '0');
			$order->no_order = $order_number;
    } else {
			$arr["message"] = "Proses edit order berhasil dilakukan";
      $order = order::find(Request::input("id-order"));
    }
		$affiliate_check = Request::input("affiliate-check");
		if (isset($affiliate_check)) { $order->affiliate = 1; } else { $order->affiliate = 0; }
		
		if (Request::input("select-auto-manage")=="None") {
			$arr["type"] = "error";
			$arr["message"] = "Silahkan pilih paket anda";
			return $arr;
		}
		$order->package_manage_id = Request::input("select-auto-manage");
		$package = Package::find(Request::input("select-auto-manage"));
		$order->total = $package->price;
		
		if (Request::input("payment-method")==1) {
			$order->order_type = "transfer_bank";
		}
		$order->save();

		if ($order->affiliate==1) {
			$order->order_status = "success";
			$invoice = Invoice::where("order_id","=",$order->id)->first();
			if (is_null($invoice)){
				$invoice = new Invoice;
				$invoice->order_id = $order->id;

				$str = 'ICLB'.$dt->format('ymdHi');
				$invoice_number = GeneralHelper::autoGenerateID($invoice, 'no_invoice', $str, 3, '0');
				$invoice->no_invoice = $invoice_number;
			} 
			$invoice->total = $order->total;
			$invoice->save();
			
			$user = User::where("email","=",Request::input("email"))->first();
			if (is_null($user)) {
				$user = new User;
				$user->email = Request::input("email");
			}
			$user->fullname=Request::input("fullname");
			if (Request::input("id-order")=="new") {
				$karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
				$string = '';
				for ($i = 0; $i < 8 ; $i++) {
					$pos = rand(0, strlen($karakter)-1);
					$string .= $karakter{$pos};
				}
				$user->password = $string;
				$user->fullname = Request::input("fullname");
				$user->type = "confirmed-email";
				$package = Package::find($order->package_manage_id);
				$user->active_auto_manage = $package->active_days * 86400;
				if ($package->max_account>$user->max_account) {
					$user->max_account = $package->max_account;
				}
				$user->save();
				
				$order->user_id = $user->id;
				$order->save();
				
				$emaildata = [
						'user' => $user,
						'password' => $string,
				];
				Mail::queue('emails.create-user', $emaildata, function ($message) use ($user) {
					$message->from('no-reply@celebgramme.com', 'Celebgramme');
					$message->to($user->email);
					$message->subject('[Celebgramme] Welcome to celebgramme.com');
				});
			}
		}
		
    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-order");
    return $arr;    
  }

  public function delete_order()
  {
		$order = Order::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }



  
}
