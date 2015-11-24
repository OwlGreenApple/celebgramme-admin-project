<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Order;
use Celebgramme\Models\Order_detail;
use Celebgramme\Models\Invoice;
use Celebgramme\Models\Admin_logs;

use Celebgramme\Helpers\GeneralHelper;
use View,Auth,Request,DB,Carbon;

class OrderController extends Controller {


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
	public function order()
	{
    // $orders = Order::all()->orderBy("id","desc");
		return View::make('admin.order.index')->with(
                  array(
                    // 'configuration'=>$configuration,
                  ));
	}

  public function load_order()
  {
    $data = Order::orderBy("id","desc")->paginate(15);
    return view('admin.order.content')->with(
                array(
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_order()
  {
    $data = Order::orderBy("id","desc")->paginate(15);
    return view('admin.order.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }
  
	public function edit_order()
  {
    $data = Order::find(Request::input("orderId"));
    return view('admin.order._editModal')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function detail_order()
  {
    $datas = Order_detail::where("order_id","=",Request::input("orderId"))->get();
    return view('admin.order._infoModal')->with(
                array(
                  'datas'=>$datas,
                ));
  }
  
	public function update_order()
  {
    $arr['type']='success';
    $arr['message']='data berhasil diupdate';
    $arr['id']=Request::input("orderId");
    
    $order = Order::find(Request::input("orderId"));
    $order->shipping_number = Request::input("noShipping");
    $order->order_shipping_status = Request::input("shippingStatus");
    $order->save();
    
    //log
    $admin = Auth::user();
    $array = [
        "admin_log_description"=>"update shipping order, order id : ".Request::input("orderId"),
        "admin_log_type"=>"update shipping order",
        "admin_id"=>$admin->id,
        "foreign_id"=>"",
        "created"=>Carbon::now()
    ];
    Admin_logs::create($array);
    
    return $arr;
  }
  
}
