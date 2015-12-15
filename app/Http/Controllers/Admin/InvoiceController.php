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

class InvoiceController extends Controller {


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
		return View::make('admin.invoice.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_invoice()
  {
        $invoices = Invoice::join('orders',"orders.id","=","invoices.order_id")
                 ->join("users","users.id","=","orders.user_id")
                 ->select("invoices.*","users.fullname","users.phone_number","users.email")
                 ->where('invoices.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('invoices.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->orderBy('invoices.created_at', 'desc')->paginate(15);

    $user = Auth::user();
    return view('admin.invoice.content')->with(
                array(
                  'user'=>$user,
                  'invoices'=>$invoices,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_invoice()
  {
        $invoices = Invoice::join('orders',"orders.id","=","invoices.order_id")
                 ->join("users","users.id","=","orders.user_id")
                 ->select("invoices.*","users.fullname","users.phone_number","users.email")
                 ->where('invoices.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
                 ->where('invoices.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                 ->orderBy('invoices.created_at', 'desc')->paginate(15);

    return view('admin.invoice.pagination')->with(
                array(
                  'invoices'=>$invoices,
                ));
  }


  
}
