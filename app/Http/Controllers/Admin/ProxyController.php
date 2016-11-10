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
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
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
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
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
  
	public function check_proxy(){
    $arr["type"] = "success";
    $arr["message"] = "Proxy Works";
		
		$port = Request::input("port");
		$cred = Request::input("cred");
		$proxy = Request::input("proxy");

		$cookiefile = base_path().'/../public_html/general/ig-cookies/check-proxies-cookiess.txt';
		$url = "https://www.instagram.com/celebgramme/?__a=1";
		$c = curl_init();


		curl_setopt($c, CURLOPT_PROXY, $proxy);
		curl_setopt($c, CURLOPT_PROXYPORT, $port);
		curl_setopt($c, CURLOPT_PROXYUSERPWD, $cred);
		curl_setopt($c, CURLOPT_PROXYTYPE, 'HTTP');
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_REFERER, $url);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_COOKIEFILE, $cookiefile);
		curl_setopt($c, CURLOPT_COOKIEJAR, $cookiefile);
		$page = curl_exec($c);
		curl_close($c);
		
		$arr = json_decode($page,true);
		if (count($arr)>0) {
			unlink($cookiefile);
		} else {
			// echo "username not found";
			$arr["type"] = "error";
			$arr["message"] = "Proxy Error";
		}
		
	
		return $arr;
	}
	
	public function check_proxy_all(){
		
	}
}
