<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Invoice;
use Celebgramme\Models\Order;
use Celebgramme\Models\User;
use Celebgramme\Models\Package;
use Celebgramme\Models\PackageUser;

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
    
    $package = Package::find($order->package_id);
    
    $packageuser = new PackageUser;
    $packageuser->package_id = $order->package_id;
    $packageuser->user_id = $order->user_id;
    $packageuser->save();
    
    $user = User::find($order->user_id);
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
    
    //create invoice
    $invoice = new Invoice;

		$dt = Carbon::now();
		$str = 'ICLB'.$dt->format('ymdHi');
    $invoice_number = GeneralHelper::autoGenerateID($invoice, 'no_invoice', $str, 3, '0');

    $invoice->no_invoice = $invoice_number;
    $invoice->total = $order->total;
    $invoice->order_id = $order->id;
    $invoice->save();
    
    $shortcode = str_replace('ICLB', '', $invoice_number);
    $emaildata = [
        'no_invoice' => $shortcode,
        'package' => $package,
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
      $message->subject('Success Payment');
    });

    return "success";
  }

  
}
