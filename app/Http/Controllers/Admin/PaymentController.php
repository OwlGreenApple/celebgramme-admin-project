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

use View,Auth,Request,DB,Carbon,Excel, Mail;

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
    if (Request::input('status')==0) { $temp_s = "="; }
    if (Request::input('status')==1) { $temp_s = "<>"; }
    if (Request::input('search')=="") {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s, "")
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
               ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.image',$temp_s,"")
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
    if (Request::input('status')==1) { $temp_s = "<>"; }
    if (Request::input('status')==0) { $temp_s = "="; }
    if (Request::input('search')=="") {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.created_at',$temp_s,'orders.updated_at')
                 ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
    } else {
      if (Request::input('status')==2) {
        $order = Order::join('users',"users.id","=","orders.user_id")
               ->select("orders.*","users.fullname","users.phone_number","users.email")
               ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
               ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
               ->orWhere('fullname','like','%'.Request::input('search').'%')
               ->orderBy('orders.created_at', 'desc')->paginate(15);
      }
      if ( (Request::input('status')==1) || (Request::input('status')==0) ){
        $order = Order::join('users',"users.id","=","orders.user_id")
                 ->select("orders.*","users.fullname","users.phone_number","users.email")
                 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->where('orders.created_at',$temp_s,'orders.updated_at')
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

    return View::make('admin.coupon.index')->with(
                  array(
                    'user'=>$user,
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
    $coupon->save();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
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

    return View::make('admin.order.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }

  public function load_order()
  {
    $arr = Order::paginate(15);

    return view('admin.order.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_order()
  {
    $arr = Order::paginate(15);
    
                              
    return view('admin.order.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function add_order()
  {
    if (Request::input("id-coupon")=="new") {
      $coupon = new Coupon;
    } else {
      $coupon = Coupon::find(Request::input("id-coupon"));
    }
    $coupon->coupon_code = Request::input("coupon_code");
    $coupon->coupon_value = Request::input("coupon_value");
    $coupon->valid_until = date("Y-m-d", intval(Request::input('valid_until')));
    $coupon->save();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }

  public function delete_order()
  {
    if (Request::input("id-coupon")=="new") {
      $coupon = new Coupon;
    } else {
      $coupon = Coupon::find(Request::input("id-coupon"));
    }
    $coupon->coupon_code = Request::input("coupon_code");
    $coupon->coupon_value = Request::input("coupon_value");
    $coupon->valid_until = date("Y-m-d", intval(Request::input('valid_until')));
    $coupon->save();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }



  
}
