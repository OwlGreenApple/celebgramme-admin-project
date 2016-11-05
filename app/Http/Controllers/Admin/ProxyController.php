<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Account;
use Celebgramme\Models\Proxies;
use Celebgramme\Models\SettingHelper; 
use Celebgramme\Models\ViewProxyUses;

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

		$total = 0;
		$availableProxy = ViewProxyUses::select("id","proxy","cred","port","auth",DB::raw(									"sum(count_proxy) as countP"))
											->groupBy("id","proxy","cred","port","auth")
											->orderBy("countP","asc")
											->having('countP', '<', 5)
											->get();
		foreach($availableProxy as $data) {
			$total += (5 - $data->countP);
		}
		
		
		return View::make('admin.proxy.index')->with(
                  array(
                    'user'=>$user,
                    'numAvailableProxy'=> $total,
                  ));
  }
  
	public function load_proxy_manager()
  {
    $user = Auth::user();
		
		if (Request::input('search')=="") {
			$data = Proxies::paginate(15);
		} else {
			$data = Proxies::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->paginate(15);
		}
    return view('admin.proxy.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_proxy_manager()
  {
		if (Request::input('search')=="") {
			$data = Proxies::paginate(15);
		} else {
			$data = Proxies::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->paginate(15);
		}
    return view('admin.proxy.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add / edit proxy berhasil dilakukan";
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');
		
		if ( Request::input("id_proxy")=="new" ) {
			$proxy = Proxies::
								where("proxy","=",Request::input("proxy"))
								->where("cred","=",Request::input("cred"))
								->where("port","=",Request::input("port"))
								->first();
			if (!is_null($proxy)) {
				$arr["type"] = "error";
				$arr["message"] = "Proxy sudah terdaftar sebelumnya";
				return $arr;
			}
			$proxy = new Proxies;
		} else {
			$proxy = Proxies::find(Request::input("id_proxy"));
		}
		$proxy->proxy = Request::input("proxy");
		$proxy->cred = Request::input("cred");
		$proxy->port = Request::input("port");
		if ( (Request::input("cred") <> "" ) && (Request::input("port")<>"") ) {
			$proxy->auth = true;
		} else {
			$proxy->auth = false;
		}
		$proxy->created = $dt->toDateTimeString();
		$proxy->save();

		return $arr;
	}

	public function delete_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete proxy berhasil dilakukan";

		$check_proxy = Proxies::find(Request::input("id"));
		if (!is_null($check_proxy)) {
			$check_proxy->delete();
		}

		return $arr;
	}
  
}
