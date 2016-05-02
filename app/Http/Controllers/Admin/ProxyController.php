<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Proxies;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator;

class ProxyController extends Controller {


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
	 * Show proxy page.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();
		return View::make('admin.proxy.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_proxy_manager()
  {
    $user = Auth::user();
		$data = Proxies::paginate(15);
    return view('admin.proxy.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_proxy_manager()
  {
		$data = Proxies::paginate(15);
    return view('admin.proxy.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add proxy berhasil dilakukan";
		
		return $arr;
	}

	public function edit_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses edit proxy berhasil dilakukan";
		
		return $arr;
	}

	public function delete_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete proxy berhasil dilakukan";
		
		return $arr;
	}




  
}
