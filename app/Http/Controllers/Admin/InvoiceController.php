<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Order;
use Celebgramme\Models\Invoice;
use View,Auth,Request,DB,Carbon;

class InvoiceController extends Controller {


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
	public function invoice()
	{
    // $orders = Order::all()->orderBy("id","desc");
		return View::make('admin.invoice.index')->with(
                  array(
                    // 'configuration'=>$configuration,
                  ));
	}

  public function load_invoice()
  {
    $data = Invoice::orderBy("id","desc")->paginate(15);
    return view('admin.invoice.content')->with(
                array(
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_invoice()
  {
    $data = Invoice::orderBy("id","desc")->paginate(15);
    return view('admin.invoice.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }
  
  
}
