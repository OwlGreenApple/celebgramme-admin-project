<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Account;
use Celebgramme\Models\Proxies;
use Celebgramme\Models\ProxyLogin;
use Celebgramme\Models\ProxyTemp;
use Celebgramme\Models\SettingHelper; 
use Celebgramme\Models\ViewProxyUses;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator, Input, Config;

class ProxyLoginController extends Controller {


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
											->having('countP', '<', 1)
											->get();
		foreach($availableProxy as $data) {
			$total += (1 - $data->countP);
		}
		
		
		return View::make('admin.proxy-login.index')->with(
                  array(
                    'user'=>$user,
                    'numAvailableProxy'=> $total,
                  ));
  }
  
	public function load_proxy_manager()
  {
		$user = Auth::user();
		if (Request::input('search')=="") {
			$collection1 = ProxyLogin::all();
		} else {
			$collection1 = ProxyLogin::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
							->get();
		}
		
		if (Request::input('data_show')=="0") {
			$collection2 = ProxyLogin::where("is_error",1)->get();
			$data = $collection1->intersect($collection2)->forPage(Request::input("page"),15);
		} else {
			$data = $collection1->forPage(Request::input("page"),15);
		}
		
    return view('admin.proxy-login.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_proxy_manager()
  {
		if (Request::input('search')=="") {
			$collection1 = ProxyLogin::all();
		} else {
			$collection1 = ProxyLogin::
							where("proxy","like","%".Request::input('search')."%")
							->orWhere("port","like","%".Request::input('search')."%")
							->orWhere(DB::raw("CONCAT(`proxy`, ':', `port`, ':', `cred`)"), 'LIKE', "%".Request::input('search')."%")
							->get();
		}
		
		if (Request::input('data_show')=="0") {
			$collection2 = ProxyLogin::where("is_error",1)->get();
			$data = $collection1->intersect($collection2);
		} else {
			$data = $collection1;
		}
		
    return view('admin.proxy-login.pagination')->with(
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
			$proxy = ProxyLogin::
								where("proxy","=",Request::input("proxy"))
								->where("cred","=",Request::input("cred"))
								->where("port","=",Request::input("port"))
								->first();
			if (!is_null($proxy)) {
				$arr["type"] = "error";
				$arr["message"] = "Proxy sudah terdaftar sebelumnya";
				return $arr;
			}
			$proxy = new ProxyLogin;
		} else {
			$proxy = ProxyLogin::find(Request::input("id_proxy"));
		}
		$proxy->proxy = Request::input("proxy");
		$proxy->cred = Request::input("cred");
		$proxy->port = Request::input("port");
		if ( (Request::input("cred") <> "" ) && (Request::input("port")<>"") ) {
			$proxy->auth = true;
		} else {
			$proxy->auth = false;
		}
		$check = Request::input("is_local_proxy");
		if (isset($check)) {
			$proxy->is_local_proxy = 1;
		} 
		else{
			$proxy->is_local_proxy = 0;
		}
		$proxy->created = $dt->toDateTimeString();
		$proxy->save();

		return $arr;
	}

	public function delete_proxy()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete proxy berhasil dilakukan";

		$check_proxy = ProxyLogin::find(Request::input("id"));
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
		if ($cred<>"") {
			curl_setopt($c, CURLOPT_PROXYUSERPWD, $cred);
		}
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
		$proxies = ProxyLogin::all();
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

		$check_proxy = ProxyLogin::find(Request::input("id_proxy"));
		if (!is_null($check_proxy)) {
			$check_proxy->delete();
		}
		
		$arr_proxy = explode(":", Request::input("proxy"));
		$proxy = new ProxyLogin;
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
  
  public function exchange_error_proxy(){
		$arr["type"]="success";
		$arr["message"]="success add proxy";
    $dt = Carbon::now()->setTimezone('Asia/Jakarta');
    
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-proxy-new-'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ($row->proxy=="") {
							continue;
						}
            
						
            $arr_proxy = explode(":", $row->proxy);
						/*
						add dari yang di excel seperti biasa
						*/
						$proxy_new = new ProxyLogin;
						$proxy_new->proxy = $arr_proxy[0];
						$proxy_new->port = $arr_proxy[1];
						$proxy_new->cred = "";
						$proxy_new->auth = 0;
						$proxy_new->is_local_proxy = 1;
						$proxy_new->created = $dt->toDateTimeString();
						$proxy_new->save();
						
						/*
						add proxy ganti dengan yang error dengan yang bisa
						*/
						/*
            $proxy = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();
            if (!is_null($proxy)) {
							$error_message.="sudah ada di database:".$row->proxy." ,";
              continue;
            } else {
							$port = $arr_proxy[1];
							$cred = $arr_proxy[2].":".$arr_proxy[3];
							$proxy = $arr_proxy[0];
							
							
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
							
							$arr_curl = json_decode($page,true);
							if (count($arr_curl)>0) {
								unlink($cookiefile);
							} else {
								// echo "username not found";
								$error_message.="Error proxy :".$row->proxy." ,";
								continue;
							}
							
							
              $proxy = new ProxyLogin;
              $proxy->proxy = $arr_proxy[0];
              $proxy->port = $arr_proxy[1];
              $proxy->cred = $arr_proxy[2].":".$arr_proxy[3];
              $proxy->auth = 1;
              $proxy->created = $dt->toDateTimeString();
              $proxy->save();
            }

            //cari proxy error, klo ada exchange, klo ga ada insert new biasa.
            $proxy_error = ProxyLogin::
                            where("is_error",1)
                            ->first();
            if (!is_null($proxy_error)) {
              $celebgramme_proxies = SettingHelper::where("proxy_id","=",$proxy_error->id)->get();
              foreach($celebgramme_proxies as $data){
                $data->cookies = "";
                $data->is_refresh = 1;
                $data->proxy_id = $proxy->id;
                $data->save();
              }
              $celebpost_proxies = Account::where("proxy_id","=",$proxy_error->id)->get();
              foreach($celebpost_proxies as $data){
                $data->proxy_id = $proxy->id;
                $data->save();
              }
              
              
              $proxy_error->delete();
            }*/
            
					}
				}
      }
			
		$arr["message"] = "success add proxy".$error_message;
    return $arr;
  }

  public function exchange_replace_proxy(){
		$arr["type"]="success";
		$arr["message"]="success replace proxy";
    $dt = Carbon::now()->setTimezone('Asia/Jakarta');
    
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-proxy-replace-'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ( ($row->proxy_old=="") || ($row->proxy_new=="") ) {
							continue;
						}
            
						
            $arr_proxy = explode(":", $row->proxy_new);
						/* 
						exchange proxy new (proxy auth old dengan proxy non auth new) 
						*/
						$proxy_new = new ProxyLogin;
						$proxy_new->proxy = $arr_proxy[0];
						$proxy_new->port = $arr_proxy[1];
						$proxy_new->cred = "";
						$proxy_new->auth = 0;
						$proxy_new->is_local_proxy = 1;
						$proxy_new->created = $dt->toDateTimeString();
						$proxy_new->save();
						
            //cari proxy old klo ada maka akan di exchange
            $arr_proxy = explode(":", $row->proxy_old);
            $proxy_old = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();
            if (!is_null($proxy_old)) {
              $celebgramme_proxies = SettingHelper::where("proxy_id","=",$proxy_old->id)->get();
              foreach($celebgramme_proxies as $data){
                $data->cookies = "";
                $data->is_refresh = 1;
                $data->proxy_id = $proxy_new->id;
                $data->save();
              }
              $celebpost_proxies = Account::where("proxy_id","=",$proxy_old->id)->get();
              foreach($celebpost_proxies as $data){
                $data->proxy_id = $proxy_new->id;
                $data->save();
              }
              
              
              $proxy_old->delete();
            }
						
						
						/* exchange proxy old (proxy auth dengan proxy auth)
            $proxy_new = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();
            if (!is_null($proxy_new)) {
							//klo ada di database, ditulis error log di return message
							$error_message.="sudah ada di database:".$row->proxy_new." ,";

              continue;
            } else {
							$port = $arr_proxy[1];
							$cred = $arr_proxy[2].":".$arr_proxy[3];
							$proxy = $arr_proxy[0];
							
							
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
							
							$arr_curl = json_decode($page,true);
							if (count($arr_curl)>0) {
								unlink($cookiefile);
							} else {
								// echo "username not found";
								$error_message.="Error proxy :".$row->proxy_new." ,";
								continue;
							}
							
							
							
							
              $proxy_new = new ProxyLogin;
              $proxy_new->proxy = $arr_proxy[0];
              $proxy_new->port = $arr_proxy[1];
              $proxy_new->cred = $arr_proxy[2].":".$arr_proxy[3];
              $proxy_new->auth = 1;
              $proxy_new->created = $dt->toDateTimeString();
              $proxy_new->save();
            }

            //cari proxy old klo ada maka akan di exchange
            $arr_proxy = explode(":", $row->proxy_old);
            $proxy_old = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();
            if (!is_null($proxy_old)) {
              $celebgramme_proxies = SettingHelper::where("proxy_id","=",$proxy_old->id)->get();
              foreach($celebgramme_proxies as $data){
                $data->cookies = "";
                $data->is_refresh = 1;
                $data->proxy_id = $proxy_new->id;
                $data->save();
              }
              $celebpost_proxies = Account::where("proxy_id","=",$proxy_old->id)->get();
              foreach($celebpost_proxies as $data){
                $data->proxy_id = $proxy_new->id;
                $data->save();
              }
              
              
              $proxy_old->delete();
            }
            */
					}
				}
      }
			
		$arr["message"] = "success replace proxy".$error_message;
    return $arr;
  }
	
  public function check_proxy_excel(){
		$arr["type"]="success";
		$arr["message"]="success add proxy";
    $dt = Carbon::now()->setTimezone('Asia/Jakarta');
    
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-proxy-new-'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ($row->proxy=="") {
							continue;
						}
            
						
            $arr_proxy = explode(":", $row->proxy);
						
						$proxy = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();				
						if (!is_null($proxy)) {
							$celebgramme_count = SettingHelper::join("settings","settings.id","=","setting_helpers.setting_id")
												->where("proxy_id","=",$proxy->id)
												->count();
							$celebpost_count = Account::where("proxy_id","=",$proxy->id)->where("is_on_celebgramme","=",0)->count();
							if ( ($celebgramme_count==0) && ($celebpost_count==0) ) {
								$error_message.="Proxy 0 : ".$row->proxy." ,";
								// $proxy->delete();
							} 
							// else {
								// $proxyTemp = new ProxyTemp;
								// $proxyTemp->proxy = $row->proxy;
								// $proxyTemp->save();
							// }
						} 
						else {
							$error_message.="Proxy Ga ada didatabase:".$row->proxy." ,";
						}
 
            /*$proxy = ProxyLogin::
                      where("proxy",$arr_proxy[0])
                      ->where("port",$arr_proxy[1])
                      ->where("cred",$arr_proxy[2].":".$arr_proxy[3])
                      ->where("auth",1)
                      ->first();
            if (!is_null($proxy)) {
							$error_message.="sudah ada di database:".$row->proxy." ,";
              continue;
            } else {
							$port = $arr_proxy[1];
							$cred = $arr_proxy[2].":".$arr_proxy[3];
							$proxy = $arr_proxy[0];
							
							
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
							
							$arr_curl = json_decode($page,true);
							if (count($arr_curl)>0) {
								unlink($cookiefile);
							} else {
								// echo "username not found";
								$error_message.="Error proxy :".$row->proxy." ,";
								continue;
							}
							
							
            }*/

					}
				}
      }
			
		$arr["message"] = "process finish ".$error_message;
    return $arr;
  }
	
}

