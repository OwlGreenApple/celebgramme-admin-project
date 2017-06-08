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
											->having('countP', '<', 3)
											->get();
		foreach($availableProxy as $data) {
			$total += (3 - $data->countP);
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
			$collection1 = Proxies::all();
		} else {
			$collection1 = Proxies::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
							->get();
		}
		
		if (Request::input('data_show')=="0") {
			$collection2 = Proxies::where("is_error",1)->get();
			$data = $collection1->intersect($collection2)->forPage(Request::input("page"),15);
		} else {
			$data = $collection1->forPage(Request::input("page"),15);
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
			$collection1 = Proxies::all();
		} else {
			$collection1 = Proxies::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
							->get();
		}
		
		if (Request::input('data_show')=="0") {
			$collection2 = Proxies::where("is_error",1)->get();
			$data = $collection1->intersect($collection2);
		} else {
			$data = $collection1;
		}
		
    return view('admin.proxy.pagination')->with(
                array(
                  'data'=>$data,
                  'page'=>Request::input('page'),
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
    $arr_ret["type"] = "success";
    $arr_ret["message"] = "Proxy Works";
		
		$port = Request::input("port");
		$cred = Request::input("cred");
		$proxy = Request::input("proxy");

		$cookiefile = base_path().'/../public_html/general/ig-cookies/check-proxies-cookiess.txt';
		$url = "https://www.instagram.com/joshwebdev/?__a=1";
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
			$arr_ret["type"] = "error";
			$arr_ret["message"] = "Proxy Error";
		}
		
	
		return $arr_ret;
	}
	
	public function check_proxy_all(){
		$proxies = Proxies::all();
		$logs = "";
		
		foreach($proxies as $data) {

			$port = $data->port;
			$cred = $data->cred;
			$proxy = $data->proxy;

			$cookiefile = base_path().'/../public_html/general/ig-cookies/check-proxies-cookiess.txt';
			if (file_exists($cookiefile)) {
				unlink($cookiefile);
			}
			$url = "https://www.instagram.com/joshwebdev/?__a=1";
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
				$arr_ret["type"] = "error";
				$arr_ret["message"] = "Proxy Error";
				$logs .= $data->proxy.":".$port.":".$cred."<br>";
			}

		
		}
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}

	public function exchange_proxy(){
		$arr["type"]="success";
		$arr["message"]="success";
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');
		
		//proxy yang lama di delete, insert proxy baru, list account proxy lama(celebgramme/celebpost) diganti dengan id proxy_baru

		$check_proxy = Proxies::find(Request::input("id_proxy"));
		if (!is_null($check_proxy)) {
			$check_proxy->delete();
		}
		
		$arr_proxy = explode(":", Request::input("proxy"));
		$proxy = new Proxies;
		$proxy->proxy = $arr_proxy[0];
		$proxy->port = $arr_proxy[1];
		$proxy->cred = $arr_proxy[2].":".$arr_proxy[3];
		$proxy->auth = 1;
		$proxy->created = $dt->toDateTimeString();
		$proxy->save();
		
		$celebgramme_proxies = SettingHelper::where("proxy_id","=",Request::input("id_proxy"))->get();
		foreach($celebgramme_proxies as $data){
			$data->cookies = "";
			$data->is_refresh = 1;
			$data->proxy_id = $proxy->id;
			$data->save();
		}
		$celebpost_proxies = Account::where("proxy_id","=",Request::input("id_proxy"))->get();
		foreach($celebpost_proxies as $data){
			$data->proxy_id = $proxy->id;
			$data->save();
		}
		
		return $arr;
	}
}
