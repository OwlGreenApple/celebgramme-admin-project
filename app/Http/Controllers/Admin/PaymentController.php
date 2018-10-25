<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Invoice;
use Celebgramme\Models\Order;
use Celebgramme\Models\OrderMeta;
use Celebgramme\Models\User;
use Celebgramme\Models\UserLog;
use Celebgramme\Models\Package;
use Celebgramme\Models\PackageUser;
use Celebgramme\Models\Coupon;
use Celebgramme\Models\Meta;
use Celebgramme\Models\AdminLog;
use Celebgramme\Models\Idaff;

use DateTime,DatePeriod,DateInterval,View,Auth,Request,DB,Carbon,Excel, Mail, Validator;

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
		
    // if (Request::input('status')==0) { $temp_s = "="; }
    // if (Request::input('status')==1) { $temp_s = "<>"; }
    if (Request::input('search')=="") {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==1) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"<>", "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.checked', 'asc')
								 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==0) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"=", "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
							 ->where('orders.order_status','<>',"cron dari affiliate")
               ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==1) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"<>","")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.checked', 'asc')
								 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==0)  {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"=","")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
    }

    $user = Auth::user();
    /*return view('admin.confirm.content')->with(
                array(
                  'user'=>$user,
                  'order'=>$order,
                  'page'=>Request::input('page'),
                ));*/
    $arr2['view'] = (string) view('admin.confirm.content')->with(
                array(
                  'user'=>$user,
                  'order'=>$order,
                  'page'=>Request::input('page'),
                ));
    $arr2['pagination'] = (string) view('admin.confirm.pagination')->with(
                array(
                  'order'=>$order,
                ));
    return $arr2;
  }
  
	public function pagination_payment()
  {
		/*
		* status 
		* 2 = All
		* 1 = confirmed
		* 0 = Not confirmed
		*/
		
    // if (Request::input('status')==1) { $temp_s = "<>"; }
    // if (Request::input('status')==0) { $temp_s = "="; }
    if (Request::input('search')=="") {
      /*if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==1) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"<>", "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.checked', 'asc')
								 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==0) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"=", "")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }*/
			$order = [] ;
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
							 ->where('orders.order_status','<>',"cron dari affiliate")
               ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==1) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"<>","")
								 ->where('orders.order_status','<>',"cron dari affiliate")
								 ->orderBy('orders.checked', 'asc')
								 ->orderBy('orders.updated_at', 'desc')->paginate(15);
      }
      if (Request::input('status')==0)  {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.confirmed_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.confirmed_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',"=","")
								 ->where('orders.order_status','<>',"cron dari affiliate")
                 ->orderBy('orders.updated_at', 'desc')->paginate(15);
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
    
		if ($order->type == "daily-activity") {
			// klo beli paket auto manage
			$package = Package::find($order->package_manage_id);
			if (!is_null($package)) {
				$packageuser = new PackageUser;
				$packageuser->package_id = $order->package_manage_id;
				$packageuser->user_id = $order->user_id;
				$packageuser->save();

				$user->active_auto_manage += $package->active_days * 86400;
				if ($user->max_account<=$package->max_account) {
					$user->max_account = $package->max_account;
				}
				$user->link_affiliate = "";
				$user->save();
			}
		}
		else if ($order->type == "max-account") {
			$user->max_account += $order->added_account;
			$user->link_affiliate = "";
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
      $message->from('no-reply@activfans.com', 'activfans');
      $message->to($user->email);
      $message->subject('[activfans] Success Payment');
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
    $arr = Coupon::where("user_id",0)->paginate(15);

    return view('admin.coupon.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_coupon()
  {
    $arr = Coupon::where("user_id",0)->paginate(15);
    
                              
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
		// if ( ($user->email == "celebgramme.dev@gmail.com") || ($user->email == "admin@admin.com") ) {
			$packages_affiliate = Package::
														where("package_group","=","auto-manage")
														;

			return View::make('admin.order.index')->with(
										array(
											'user'=>$user,
											'packages_affiliate'=>$packages_affiliate,
										));
		// } else {
			// return "NOT authorized";
		// }
  }

  public function load_order()
  {
		$admin = Auth::user();
    $arr = Order::select("orders.*","users.email","users.fullname")
              ->join("users","users.id","=","orders.user_id")
              ->where("no_order","like","%".Request::input('keyword')."%")
              ->orWhere("email","like","%".Request::input('keyword')."%")
              ->orWhere("fullname","like","%".Request::input('keyword')."%")
              ->orderBy('orders.id', 'desc')->paginate(15);
      //dd($arr);
		/*if (Request::input('keyword') == "" ) {
			$arr = Order::orderBy('id', 'desc')->paginate(15);
		} else {
			$arr = Order::select("orders.*")
							->leftJoin("users","users.id","=","orders.user_id")
							->where("no_order","like","%".Request::input('keyword')."%")
							->orWhere("email","like","%".Request::input('keyword')."%")
							->orWhere("fullname","like","%".Request::input('keyword')."%")
							->orderBy('orders.id', 'desc')->paginate(15);
		}*/

    /*return view('admin.order.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));*/

      $arr2['view'] = (string) view('admin.order.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
      $arr2['pagination'] = (string) view('admin.order.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
      return $arr2;
  }
  
  public function pagination_order()
  {
    $arr = Order::orderBy('id', 'desc')->paginate(15);
		if (Request::input('keyword') == "" ) {
			$arr = Order::orderBy('id', 'desc')->paginate(15);
		} else {
			$arr = Order::select("orders.*")
							->leftJoin("users","users.id","=","orders.user_id")
							->where("no_order","like","%".Request::input('keyword')."%")
							->orWhere("email","like","%".Request::input('keyword')."%")
							->orWhere("fullname","like","%".Request::input('keyword')."%")
							->orderBy('orders.id', 'desc')->paginate(15);
		}
    
                              
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
		$order->image = "no image, from admin" ;
		
		if (Request::input("payment-method")==1) {
			$order->order_type = "transfer_bank";
		}
		$order->save();

		if ($order->affiliate==1) {
			$order->checked = 1;
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
					$message->from('no-reply@activfans.com', 'activfans');
					$message->to($user->email);
					$message->subject('[activfans] Welcome to activfans.com');
				});
			}
			$adminlog = new AdminLog;
			$adminlog->user_id = Auth::user()->id;
			$adminlog->description = 'Create Order, '.$user->email.', '.$order->total.", ".$order->no_order;
			$adminlog->save();
		
		}
		
		OrderMeta::createMeta("logs","create order by admin",$order->id);
		
    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-order");
    return $arr;    
  }

  public function delete_order()
  {
		$order = Order::find(Request::input("id"));
		if (!is_null($order)) {
			if ( ($order->order_status <> "success") && ($order->order_status <> "cron dari affiliate") ) {
				$order->delete();
			}
		}

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }

  public function show_more(){
    return OrderMeta::getMeta(Request::input('id'),Request::input('action'));
  }

  public function success_order(){
    $user = Auth::user();

    return view('admin.success-order.index')->with('user',$user);
  }

  public function load_success_order(){
    //dd(Request::input('bulan'));
    $orders = Order::where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->paginate(15);
								
    $total = Order::select("total")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->get()->sum("total");
    $total -= Order::select("discount")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->get()->sum("discount");
		$arr['total'] = number_format($total,0,'','.');
		
    $total = Order::select("total")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->where('package_manage_id','=',41)
                ->where('package_manage_id','=',42)
                ->where('package_manage_id','=',43)
                ->get()->sum("total");
    $total -= Order::select("discount")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->where('package_manage_id','=',41)
                ->where('package_manage_id','=',42)
                ->where('package_manage_id','=',43)
                ->get()->sum("discount");
		$arr['totalaffiliate'] = number_format($total,0,'','.');
		
    $total = Order::select("total")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
								->where('order_type','=',"rico-from-admin")
                ->get()->sum("total");
    $total -= Order::select("discount")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
								->where('order_type','=',"rico-from-admin")
                ->get()->sum("discount");
		$arr['totalamelia'] = number_format($total,0,'','.');

    $total = Order::select("total")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->where('package_manage_id','!=',41)
                ->where('package_manage_id','!=',42)
                ->where('package_manage_id','!=',43)
                ->where('order_type','!=',"rico-from-admin")
                ->get()->sum("total");
    $total -= Order::select("discount")
								->where('updated_at','like',Request::input('bulan').'%')
                ->where(function($q) {
                  $q->where('order_status','success')
                    ->orWhere('order_status','like','cron%');
                })
                ->where('total','!=',0)
                ->where('package_manage_id','!=',41)
                ->where('package_manage_id','!=',42)
                ->where('package_manage_id','!=',43)
                ->where('order_type','!=',"rico-from-admin")
                ->get()->sum("discount");
		$arr['totalnonaffiliate'] = number_format($total,0,'','.');

    $arr['view'] = (string)view('admin.success-order.content')
                            ->with(array(
                                  'arr'=>$orders,
                                  'page'=>Request::input('page'),
                              ));
    $arr['pagination'] = (string) view('admin.success-order.pagination')
                            ->with('arr',$orders);
    return $arr;
  }

  public function index_idaff(){
    $user = Auth::user();

    return view('admin.idaff.index')->with('user',$user);
  }

  public function post_back_idaff(){  
    $idaff = Idaff::where("invoice","=",Request::input("invoice"))->first();
    if (is_null($idaff)){
      $idaff = new Idaff;
      $idaff->trans_id = Request::input("transid");
      $idaff->invoice = Request::input("invoice");
      $idaff->executed = 0;
    } else {
      $idaff = Idaff::where("invoice","=",Request::input("invoice"))->first();
    }
    
    if($idaff->executed){
      $arr['status'] = 'error';
      $arr['message'] = 'Invoice telah dieksekusi';
      return $arr;
    }

    $idaff->name = Request::input("cname");
    $idaff->email = Request::input("cemail");
    $idaff->phone = Request::input("cmphone");
    $idaff->status = "success";
    $idaff->grand_total = Request::input("grand_total");
    $idaff->save();
    
    if ( (strtolower($idaff->status) == "success") && (!$idaff->executed) ) {
      $flag = false;
      $isi_form_kaos = false;
      $user = User::where("email","=",$idaff->email)->first();
      if (is_null($user)) {
        $flag = true;
        $karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
        $string = '';
        for ($i = 0; $i < 8 ; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $user = new User;
        $user->email = $idaff->email;
        $user->password = $string;
        $user->fullname = $idaff->name;
        $user->type = "confirmed-email";
        $user->save();
      }
      
      $dt = Carbon::now()->setTimezone('Asia/Jakarta');
      $order = new Order;
      $str = 'OCLB'.$dt->format('ymdHi');
      $order_number = GeneralHelper::autoGenerateID($order, 'no_order', $str, 3, '0');
      $order->no_order = $order_number;
      $order->order_status = "cron dari affiliate";
      
      $package = null;
      if ( (intval(Request::input("grand_total")) <500000 ) && (intval(Request::input("grand_total")) >=495000 ) ) {
        $order->package_manage_id = 41;
        $package = Package::find(41);
      }
      else if ( (intval(Request::input("grand_total")) <600000 ) && (intval(Request::input("grand_total")) >=595000 ) ) {
        $order->package_manage_id = 43;
        $package = Package::find(43);
      }
      else if ( (intval(Request::input("grand_total")) <700000 ) && (intval(Request::input("grand_total")) >=695000 ) ) {
        $order->package_manage_id = 42;
        $package = Package::find(42);
      }
      
      if(is_null($package)){
        $arr['status'] = 'error';
        $arr['message'] = 'Paket tidak ada';
        return $arr;
      }

      $order->total = $package->price;
      $order->user_id = $user->id;
      $order->save();
      
      OrderMeta::createMeta("logs","create order from affiliate",$order->id);
      
      if ($flag) {
        $user->active_auto_manage = $package->active_days * 86400;
        $user->max_account = $package->max_account;
        $user->save();
        
        $emaildata = [
            'user' => $user,
            'password' => $string,
            'isi_form_kaos' => $isi_form_kaos,
        ];
        Mail::queue('emails.create-user', $emaildata, function ($message) use ($user) {
          $message->from('no-reply@activfans.com', 'activfans');
          $message->to($user->email);
          $message->subject('[activfans] Welcome to activfans.com (Info Login & Password)');
        });
      
      } else {
        $t = $package->active_days * 86400;
        $days = floor($t / (60*60*24));
        $hours = floor(($t / (60*60)) % 24);
        $minutes = floor(($t / (60)) % 60);
        $seconds = floor($t  % 60);
        $time = $days."D ".$hours."H ".$minutes."M ".$seconds."S ";

        $user_log = new UserLog;
        $user_log->email = $user->email;
        $user_log->admin = "Adding time from cron";
        $user_log->description = "give time to member. ".$time;
        $user_log->created = $dt->toDateTimeString();
        $user_log->save();
        
        
        $user->active_auto_manage += $package->active_days * 86400;
        $user->save();
        
        
        $emaildata = [
            'user' => $user,
            'isi_form_kaos' => $isi_form_kaos,
        ];
        Mail::queue('emails.adding-time-user', $emaildata, function ($message) use ($user) {
          $message->from('no-reply@activfans.com', 'activfans');
          $message->to($user->email);
          $message->subject('[activfans] Congratulation Pembelian Sukses, & Kredit waktu sudah ditambahkan');
        });
        
      }
      
      $idaff->executed = 1;
      $idaff->save();
    }

		$arr['status'] = 'success';
    $arr['message'] = 'Success';
    return $arr;
  }

  public function order_chart(){
    $user = Auth::user();

    if($user->email == "celebgramme.dev@gmail.com" || $user->email == "admin@admin.com"){
      return view('admin.order-chart.index')->with('user',$user);
    } else {
      echo 'Not authorized';
    }
  }

  public function load_chart(){
    $user = Auth::user();

    if($user->email == "celebgramme.dev@gmail.com" || $user->email == "admin@admin.com"){
      
    } else {
      return 'Not authorized';
    }

    $from = date(Request::input('from'));
    $to = date(Request::input('to'));

    $arrbank_pending = [];
    $arrbank_success = [];
    $arramelia_success = [];
    $arrcron = [];
    $arrall = [];

    if(Request::input('select_group')=='Daily'){
      $bank_pending = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','pending')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();
      
      foreach ($bank_pending as $order) {
        $arrbank_pending[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }
      
      //$bank_pending = str_replace('date', 'label', $bank_pending);

      $bank_success = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($bank_success as $order) {
        $arrbank_success[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      //$bank_success = str_replace('date', 'label', $bank_success);

      $amelia_success = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as orders'))
                ->where('order_type','rico-from-admin')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($amelia_success as $order) {
        $arramelia_success[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      //$amelia_success = str_replace('date', 'label', $amelia_success);

      $cron = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as orders'))
                ->where('order_type','')
                ->where('order_status','like','%cron%')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($cron as $order) {
        $arrcron[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      //$cron = str_replace('date', 'label', $cron);

      $all = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as orders'))
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($all as $order) {
        $arrall[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      //$cron = str_replace('date', 'label', $cron);      

    } /*else if(Request::input('select_group')=='Weekly'){
      $bank_pending = Order::select('created_at',DB::raw("CONCAT_WS('-',YEAR(created_at),WEEK(created_at)) as week"), DB::raw('count(*) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','pending')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('week')
                ->get();

      //$bank_pending = str_replace('month', 'label', $bank_pending);
      foreach ($bank_pending as $order) {
        $arrbank_pending[] =  array("x"=> strtotime($order->created_at)*1000, "y"=>$order->orders);
      }

      $bank_success = Order::select('created_at',DB::raw("CONCAT_WS('-',YEAR(created_at),WEEK(created_at)) as week"), DB::raw('count(*) as orders')))
                ->where('order_type','transfer_bank')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('week')
                ->get();

      //$bank_success = str_replace('month', 'label', $bank_success);
      foreach ($bank_success as $order) {
        $arrbank_success[] =  array("x"=> strtotime($order->created_at)*1000, "y"=>$order->orders);
      }

      $amelia_success = Order::select('created_at',DB::raw("CONCAT_WS('-',YEAR(created_at),WEEK(created_at)) as week"), DB::raw('count(*) as orders')))
                ->where('order_type','rico-from-admin')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('week')
                ->get();

      //$amelia_success = str_replace('month', 'label', $amelia_success);
      foreach ($amelia_success as $order) {
        $arramelia_success[] =  array("x"=> strtotime($order->created_at)*1000, "y"=>$order->orders);
      }

      $cron = Order::select(DB::raw('created_at',DB::raw("CONCAT_WS('-',YEAR(created_at),WEEK(created_at)) as week"), DB::raw('count(*) as orders'))
                ->where('order_type','')
                ->where('order_status','like','%cron%')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('week')
                ->get();

      //$cron = str_replace('month', 'label', $cron);
      foreach ($cron as $order) {
        $arrcron[] =  array("x"=> strtotime($order->created_at)*1000, "y"=>$order->orders);
      }


    }*/ else {
      $bank_pending = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('count(*) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','pending')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      //$bank_pending = str_replace('month', 'label', $bank_pending);
      foreach ($bank_pending as $order) {
        $arrbank_pending[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $bank_success = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('count(*) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      //$bank_success = str_replace('month', 'label', $bank_success);
      foreach ($bank_success as $order) {
        $arrbank_success[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $amelia_success = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('count(*) as orders'))
                ->where('order_type','rico-from-admin')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      //$amelia_success = str_replace('month', 'label', $amelia_success);
      foreach ($amelia_success as $order) {
        $arramelia_success[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $cron = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('count(*) as orders'))
                ->where('order_type','')
                ->where('order_status','like','%cron%')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      //$cron = str_replace('month', 'label', $cron);
      foreach ($cron as $order) {
        $arrcron[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $all = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('count(*) as orders'))
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      //$cron = str_replace('month', 'label', $cron);
      foreach ($all as $order) {
        $arrall[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

    }
    
    /*$bank_pending = str_replace('orders', 'y', $bank_pending);
    $bank_success = str_replace('orders', 'y', $bank_success);
    $amelia_success = str_replace('orders', 'y', $amelia_success);
    $cron = str_replace('orders', 'y', $cron);*/

    /*$arr['bank_pending'] = $bank_pending;
    $arr['bank_success'] = $bank_success;
    $arr['amelia_success'] = $amelia_success;
    $arr['cron'] = $cron;*/

    $arr['bank_pending'] = $arrbank_pending;
    $arr['bank_success'] = $arrbank_success;
    $arr['amelia_success'] = $arramelia_success;
    $arr['cron'] = $arrcron;
    $arr['all'] = $arrall;
    $arr['type'] = Request::input('select_group');

    return $arr;
  }

  public function price_chart(){
    $user = Auth::user();

    if($user->email == "celebgramme.dev@gmail.com" || $user->email == "admin@admin.com"){
      return view('admin.price-chart.index')->with('user',$user);
    } else {
      echo 'Not authorized';
    }
  } 

  public function load_price_chart(){
    $user = Auth::user();

    if($user->email == "celebgramme.dev@gmail.com" || $user->email == "admin@admin.com"){
      
    } else {
      return 'Not authorized';
    }

    $from = date(Request::input('from'));
    $to = date(Request::input('to'));

    $arrbank_pending = [];
    $arrbank_success = [];
    $arramelia_success = [];
    $arrcron = [];
    $arrall = [];

    if(Request::input('select_group')=='Daily'){
      $bank_pending = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','pending')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();
      
      foreach ($bank_pending as $order) {
        $arrbank_pending[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      $bank_success = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($bank_success as $order) {
        $arrbank_success[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      $amelia_success = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as orders'))
                ->where('order_type','rico-from-admin')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($amelia_success as $order) {
        $arramelia_success[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      $cron = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as orders'))
                ->where('order_type','')
                ->where('order_status','like','%cron%')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($cron as $order) {
        $arrcron[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

      $all = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as orders'))
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

      foreach ($all as $order) {
        $arrall[] =  array("x"=> strtotime($order->date)*1000, "y"=>$order->orders);
      }

    } else {
      $bank_pending = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('sum(total) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','pending')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      foreach ($bank_pending as $order) {
        $arrbank_pending[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $bank_success = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('sum(total) as orders'))
                ->where('order_type','transfer_bank')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      foreach ($bank_success as $order) {
        $arrbank_success[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $amelia_success = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('sum(total) as orders'))
                ->where('order_type','rico-from-admin')
                ->where('order_status','success')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      foreach ($amelia_success as $order) {
        $arramelia_success[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $cron = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('sum(total) as orders'))
                ->where('order_type','')
                ->where('order_status','like','%cron%')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();

      foreach ($cron as $order) {
        $arrcron[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

      $all = Order::select(DB::raw("CONCAT_WS('-',MONTHNAME(created_at),YEAR(created_at)) as month"), DB::raw('sum(total) as orders'))
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('month')
                ->orderBy('created_at','asc')
                ->get();
      
      foreach ($all as $order) {
        $arrall[] =  array("x"=> strtotime($order->month)*1000, "y"=>$order->orders);
      }

    }
    
    $arr['bank_pending'] = $arrbank_pending;
    $arr['bank_success'] = $arrbank_success;
    $arr['amelia_success'] = $arramelia_success;
    $arr['cron'] = $arrcron;
    $arr['all'] = $arrall;
    $arr['type'] = Request::input('select_group');

    return $arr;
  }
}
