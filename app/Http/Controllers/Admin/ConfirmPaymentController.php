<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Confirm_payment;
use Celebgramme\Models\Order;
use Celebgramme\Models\OrderMeta;
use Celebgramme\Models\Invoice;
use Celebgramme\Models\Coupon;
use Celebgramme\Models\Admin_logs;
use Celebgramme\Models\Setting;

use Celebgramme\Helpers\GeneralHelper;
use View,Auth,Request,DB,Carbon,Mail,App;

class ConfirmPaymentController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
		// $this->middleware('auth');
	// }

	/**
	 * Show bpv ranking page.
	 *
	 * @return Response
	 */
	public function index()
	{
    // $orders = Order::all()->orderBy("id","desc");
		return View::make('admin.confirm_payment.index')->with(
                  array(
                    // 'configuration'=>$configuration,
                  ));
	}

  public function load_confirm_payment()
  {
    $data = Confirm_payment::orderBy("id","desc")->paginate(15);
    return view('admin.confirm_payment.content')->with(
                array(
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_confirm_payment()
  {
    $data = Confirm_payment::orderBy("id","desc")->paginate(15);
    return view('admin.confirm_payment.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }
  
	public function confirm_payment()
  {
    $arr['type']='success';
    $arr['message']='Konfirmasi pembayaran berhasil dilakukan';
    
    $confirm = Confirm_payment::find(Request::input("confirmId"));
    $confirm->confirm_status = true;
    $confirm->save();
    
    $orders = Order::select("orders.*","customers.email")
              ->leftJoin("customers","customers.id","=","orders.customer_id")->where("no_order","=",$confirm->no_order)->get();
    if (Request::input("paymentMethod") == "bank_transfer") {
      $invoice = new Invoice;
      // $no_invoice = GeneralHelper::autoGenerateID($invoice,'no_invoice','IAXM'.date('ymdHi'),3);
      $no_invoice = GeneralHelper::autoGenerateID($invoice,'no_invoice','IAXM'.Carbon::now()->format('ymdHi'),3);
      $invoice->total = Request::input('total');
      $invoice->no_invoice = $no_invoice;
      $invoice->save();
      
      foreach ($orders as $data) { 
        $order = Order::find($data->id);
        $order->order_payment_status = "success";
        $order->invoice_id = $invoice->id;
        $order->save();
        $ref_id = $order->referral_id;
        $customer_id = $order->customer_id;
      }
      if (OrderMeta::getMeta($confirm->no_order, 'create_coupon') == 'true'){
        $coupon_value = intval(Setting::getValue('coupon_value'));
        if ($ref_id != 0){
          Coupon::createCoupon($coupon_value, 'referral_dailydeals', $ref_id, 0, 'DailyDeals Referral Coupon');
        }
        Coupon::createCoupon($coupon_value, 'self', $customer_id, $ref_id, 'DailyDeals Shopping Coupon');
      }
      $status = "success";
    }
    if (Request::input("paymentMethod") == "veritrans") {
      if (Request::input('action')=="accept") {
        $status = "success";
        
        $invoice = new Invoice;
        // $no_invoice = GeneralHelper::autoGenerateID($invoice,'no_invoice','IAXM'.date('ymdHi'),3);
        $no_invoice = GeneralHelper::autoGenerateID($invoice,'no_invoice','IAXM'.Carbon::now()->format('ymdHi'),3);
        $invoice->total = Request::input('total');
        $invoice->no_invoice = $no_invoice;
        $invoice->save();
        
      } 
      if (Request::input('action')=="deny") {
        $status = "deny";
        $arr['type']='error';
        $arr['message']='Pembayaran di deny';
      }
      
      foreach ($orders as $data) { 
        $order = Order::find($data->id);
        $order->order_payment_status = $status;
        if (Request::input('action')=="accept") {
          $order->invoice_id = $invoice->id;
        }        
        $order->save();
        $ref_id = $order->referral_id;
        $customer_id = $order->customer_id;
      }
      if (Request::input('action')=="accept") {
        if (OrderMeta::getMeta($confirm->no_order, 'create_coupon') == 'true'){
          $coupon_value = intval(Setting::getValue('coupon_value'));
          if ($ref_id != 0){
            Coupon::createCoupon($coupon_value, 'referral_shopping', $ref_id, 0, 'DailyDeals Referral Coupon');
          }
          Coupon::createCoupon($coupon_value, 'self', $customer_id, $ref_id, 'DailyDeals Shopping Coupon');
        }
      }
      
    }
    
    if ($status=="success") {
      //send email
      if (App::environment() == 'local'){
        $url = 'http://localhost/axiamarket/check-status-order/';
      }
      else if (App::environment() == 'production'){
        $url = 'http://axiamarket.com/check-status-order/';
      }
      $emaildata = [
        'order_number' => $confirm->no_order,
        'url' => $url,
      ];
      
      $no_invoice = substr($no_invoice,4);
      Mail::queue('emails.successpayment', $emaildata, function ($message) use ($orders,$no_invoice) {
        $message->from('no-reply@axiamarket.com', 'AxiaMarket');
        $message->to($orders[0]->email);
        $message->subject('[Axiamarket] - Invoice #'.$no_invoice);
      });
      
      //log
      $admin = Auth::user();
      $array = [
          "admin_log_description"=>"accept confirm payment no invoice : ".$no_invoice,
          "admin_log_type"=>"konfirmasi confirm payment",
          "admin_id"=>$admin->id,
          "foreign_id"=>"",
          "created"=>Carbon::now()
      ];
      Admin_logs::create($array);
    }
    
    return $arr;
  }
  

	public function test()
  {
      $emaildata = [
        'url' => "",
        'showed' => false,
      ];
      Mail::queue('emails.successpayment', $emaildata, function ($message)  {
        $message->from('no-reply@axiamarket.com', 'AxiaMarket');
        $message->to("tesasdasdat@gmail.com");
        $message->subject('[Axiamarket] - Invoice #');
      });
      return "ww";
  }
  
  public function check_order_confirm()
  {
    $orders = Order::where("no_order","=",Request::input("noOrder"))->get();
  	return View::make('admin.confirm_payment._checkModal')->with(
                  array(
                    'orders'=>$orders,
                  ));
  }
  
}
