<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Meta;
use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\SettingMeta; 
use Celebgramme\Models\SettingHelper; 
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\TemplateEmail;
use Celebgramme\Models\LinkProxySetting;
use Celebgramme\Models\Proxies;
use Celebgramme\Models\SettingCounter;

use View,Auth,Request,DB,Carbon,Excel,Mail,Input;

class SettingController extends Controller {


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
	 * Show Setting Page.
	 *
	 * @return Response
	 */
	public function index($search="")
	{
    $user = Auth::user();
		$filenames = Meta::where("meta_name","=","fl_name")->get();
		$status_server = Meta::where("meta_name","=","status_server")->first()->meta_value;
		$template = TemplateEmail::all();
		
		// $availableProxy = Proxies::leftJoin("link_proxies_settings","link_proxies_settings.proxy_id","=","proxies.id")
								// ->select("proxies.id","proxies.proxy","proxies.cred","proxies.port","proxies.auth")
                // ->groupBy("proxies.id","proxies.proxy","proxies.cred","proxies.port","proxies.auth")
								// ->havingRaw('count(proxies.id) < 5')
								// ->get();
		$availableProxy = Proxies::leftJoin("setting_helpers","setting_helpers.proxy_id","=","proxies.id")
								->select("proxies.id","proxies.proxy","proxies.cred","proxies.port","proxies.auth")
                ->groupBy("proxies.id","proxies.proxy","proxies.cred","proxies.port","proxies.auth")
								->havingRaw('count(proxies.id) < 5')
								->get();
		// dd($availableProxy);
		$arrAvailableProxy = array();
		foreach($availableProxy as $data) {
			$dataNew = array();
			// $dataNew[] = $data->id;
			$dataNew["id"] = $data->id;
			if ($data->auth) {
				$dataNew["value"] = $data->proxy.":".$data->port.":".$data->cred;
				// $dataNew[] = $data->proxy.":".$data->port.":".$data->cred;
			} else {
				$dataNew["value"] = $data->proxy;
				// $dataNew[] = $data->proxy;
			}
			$arrAvailableProxy[] = $dataNew;	
		}
		
								
		return View::make('admin.setting.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                    'filenames'=>$filenames,
                    'status_server'=>$status_server,
										'templates'=>$template,
										'availableProxy'=>$arrAvailableProxy,
                  ));
	}

  public function load_setting()
  {
		$admin = Auth::user();
		// if (Request::input('filename')=="all") {
			if (Request::input('keyword')=="") {
				$arr = Setting::where("type","=","temp")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			} else if (Request::input('keyword')=="update") {
				$arr = Setting::where("type","=","temp")
							 ->where("status_follow_unfollow","=","on")
							 ->where("activity","=","follow")
							 ->where("status","=","started")
							 ->where("follow_source","=","hashtags")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			} else {
				$arr = Setting::
								leftJoin('setting_metas', function ($join) {
										$join->on('settings.id', '=', 'setting_metas.setting_id');
								})							
							 ->leftJoin("users","users.id","=","settings.user_id")
							 ->select("settings.*")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("settings.type","=","temp")
							 ->where(function ($query){
								 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
								 ->orWhere("meta_value","like","%".Request::input('keyword')."%")
								 ->orWhere("users.email","like","%".Request::input('keyword')."%");
							 })
							 ->groupBy("settings.id")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			}
			/*
		} else if (Request::input('filename')=="-") {
			if (Request::input('keyword')=="") {
				$arr = Setting::
							 leftJoin("setting_metas","setting_metas.setting_id","=","settings.id")
							 ->select("settings.*")
							 ->where("settings.type","=","temp")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("setting_metas.meta_value","=","-")
							 ->orderBy('settings.id', 'asc')
							 ->paginate(15);
			} else {
				$arr = Setting::
							 leftJoin("setting_metas","setting_metas.setting_id","=","settings.id")
							 ->leftJoin("users","users.id","=","settings.user_id")
							 ->select("settings.*")
							 ->where("settings.type","=","temp")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("setting_metas.meta_value","=","-")
							 ->where(function ($query){
								 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
								 ->orWhere("meta_value","like","%".Request::input('keyword')."%")
								 ->orWhere("users.email","like","%".Request::input('keyword')."%");
							 })
							 ->orderBy('settings.id', 'asc')
							 ->paginate(15);
			}
		}
    */
    return view('admin.setting.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_setting()
  {
		// if (Request::input('filename')=="all") {
			if (Request::input('keyword')=="") {
				$arr = Setting::where("type","=","temp")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			} else if (Request::input('keyword')=="update") {
				$arr = Setting::where("type","=","temp")
							 ->where("status_follow_unfollow","=","on")
							 ->where("activity","=","follow")
							 ->where("status","=","started")
							 ->where("follow_source","=","hashtags")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			} else {
				$arr = Setting::
								leftJoin('setting_metas', function ($join) {
										$join->on('settings.id', '=', 'setting_metas.setting_id');
								})							
							 ->leftJoin("users","users.id","=","settings.user_id")
							 ->select("settings.id")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("settings.type","=","temp")
							 ->where(function ($query){
								 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
								 ->orWhere("meta_value","like","%".Request::input('keyword')."%")
								 ->orWhere("users.email","like","%".Request::input('keyword')."%");
							 })
							 ->groupBy("settings.id")
							 ->orderBy('id', 'asc')
							 ->paginate(15);
			}
			/*
		} else if (Request::input('filename')=="-") {
			if (Request::input('keyword')=="") {
				$arr = Setting::
							 leftJoin("setting_metas","setting_metas.setting_id","=","settings.id")
							 ->select("settings.id")
							 ->where("settings.type","=","temp")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("setting_metas.meta_value","=","-")
							 ->orderBy('settings.id', 'asc')
							 ->paginate(15);
			} else {
				$arr = Setting::
							 leftJoin("setting_metas","setting_metas.setting_id","=","settings.id")
							 ->leftJoin("users","users.id","=","settings.user_id")
							 ->select("settings.id")
							 ->where("settings.type","=","temp")
							 ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("setting_metas.meta_value","=","-")
							 ->where(function ($query){
								 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
								 ->orWhere("meta_value","like","%".Request::input('keyword')."%")
								 ->orWhere("users.email","like","%".Request::input('keyword')."%");
							 })
							 ->orderBy('settings.id', 'asc')
							 ->paginate(15);
			}
		}
*/

    return view('admin.setting.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function update_post($konfirmasiId)
  {
    $request = RequestModel::find($konfirmasiId);
    $request->status=true;
    $request->save();

    $user = User::find($request->user_id);
    $user->balance = $user->balance - $request->likes;
    $user->save();
    
    return "success";
  }

	public function update_setting_proxy()
	{
		if (Request::input("hiddenIdProxy") <> "" ) {
			$proxy = Proxies::find(Request::input("hiddenIdProxy"));
			if (is_null($proxy)) {
				$arr["message"] = "Error proxy tidak terdaftar";
				return $arr;
			} else {
				$settingHelper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
				if (is_null($settingHelper)) {
					$settingHelper = new SettingHelper;
					$settingHelper->setting_id = Request::input("setting-id");
				}
				$settingHelper->proxy_id = Request::input("hiddenIdProxy");
				$settingHelper->save();
				$arr["proxy"] = $proxy->proxy.":".$proxy->port.":".$proxy->cred;
			}
		} else if (Request::input("hiddenIdProxy") == "" ) {
			$settingHelper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
			if (is_null($settingHelper)) {
				$settingHelper = new SettingHelper;
				$settingHelper->setting_id = Request::input("setting-id");
			}
			$settingHelper->proxy_id = "";
			$settingHelper->save();
			$arr["proxy"] = "";
		}
		$arr["message"] = "success";
		$arr["id"] = Request::input("setting-id");
		
		return $arr;
	}
	
  public function update_server_automation()
  {
		$settingHelper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
		if (is_null($settingHelper)) {
			$settingHelper = new SettingHelper;
			$settingHelper->setting_id = Request::input("setting-id");
		}
		$settingHelper->server_automation = Request::input("server-automation");
		$settingHelper->save();
		
		$arr["id"] = Request::input("setting-id");
		$arr["type"] = "success";
		$arr["servername"] = Request::input("server-automation");
		return $arr;
	}

	public function update_method_automation()
	{
		$settingHelper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
		if (is_null($settingHelper)) {
			$settingHelper = new SettingHelper;
			$settingHelper->setting_id = Request::input("setting-id");
		}
		if (Request::input("radio_method_automation") == "manual") {
			$settingHelper->use_automation = 0;
		} else {
			$settingHelper->use_automation = 1;
		}
		$settingHelper->save();
		
		return "success";
	}

	public function update_status_server()
  {
		$meta = Meta::where('meta_name','=','status_server')->first();
		$meta->meta_value = Input::get("statusServer");
		$meta->save();
		
		return "success";
	}

	/**
	 * Show Setting Page.
	 *
	 * @return Response
	 */
	public function automation($search="")
	{
    $user = Auth::user();
		
								
		return View::make('admin.setting-automation.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                  ));
	}

  public function load_automation()
  {
		$admin = Auth::user();
		if (Request::input('keyword')=="") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  } else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("settings.insta_username","like","%".Request::input('keyword')."%")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}
					
			
    return view('admin.setting-automation.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_automation()
  {
		if (Request::input('keyword')=="") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  } else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("settings.insta_username","like","%".Request::input('keyword')."%")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}


    return view('admin.setting-automation.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function get_logs_automation() {
		$logs = "";
		$counter =1;
		
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting = Setting::find(Request::input('id'));
		
		if ($setting_helper->server_automation == "A1(automation-1)") {
			$file_server = "http://192.186.146.248/";
		}
		if ($setting_helper->server_automation == "A2(automation-2)") {
			$file_server = "http://192.186.146.246/";
		}

		$file_server .= "logs-IG-account/".$setting->insta_username.".txt";
		$ch = curl_init($file_server);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
			$logs = file_get_contents($file_server);
		} else {
			$logs = "-";
		}
		curl_close($ch);
		
		
		// $setting_counters = SettingCounter::where("setting_id","=",Request::input('id'))
												// ->orderBy("created","desc")
												// ->get();
		// foreach($setting_counters as $setting_counter) {
			// $logs .= $setting_counter->created."<br> ".$setting_counter->description;
			// $logs .= "<br><br>";
			// $counter +=1;
			// if ($counter>3) {break;}
		// }
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
	public function get_logs_automation_daily() {
		$logs = "";
		$counter =1;
		
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting = Setting::find(Request::input('id'));
		
		if ($setting_helper->server_automation == "A1(automation-1)") {
			$server = "http://192.186.146.248/";
		}
		if ($setting_helper->server_automation == "A2(automation-2)") {
			$server = "http://192.186.146.246/";
		}

		$dt = Carbon::now()->setTimezone('Asia/Jakarta');		
		for ($i=1;$i<=7;$i++) {
			$logs .= "<tr>";
			$logs .= "<td>".$dt->toDateString()."</td>";
			

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."unfollow.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."follow.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."like.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."comment.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);
			
			$logs .= "</tr>";
			
			
			$dt->subDay();
		}
		
		/*$setting_counters = SettingCounter::
												select(DB::raw('SUM(follows_counter) as follows_counter'),DB::raw('SUM(likes_counter) as likes_counter'),DB::raw('SUM(comments_counter) as comments_counter'),DB::raw('SUM(unfollows_counter) as unfollows_counter'),DB::raw('DATE(created) as datum'))
												->where("setting_id","=",Request::input('id'))
												->orderBy("created","desc")
												->groupBy("setting_id","datum")
												->get();
		foreach($setting_counters as $setting_counter) {
			$logs .= "<tr>";
			$logs .= "<td>".$setting_counter->datum."</td>";
			$logs .= "<td>".$setting_counter->unfollows_counter."</td>";
			$logs .= "<td>".$setting_counter->follows_counter."</td>";
			$logs .= "<td>".$setting_counter->likes_counter."</td>";
			$logs .= "<td>".$setting_counter->comments_counter."</td>";
			$logs .= "</tr>";
			$counter +=1;
			if ($counter>7) {break;}
		}*/
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}

	public function get_logs_automation_hourly() {
		$logs = "";
		$counter =1;
		
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting = Setting::find(Request::input('id'));
		
		if ($setting_helper->server_automation == "A1(automation-1)") {
			$server = "http://192.186.146.248/";
		}
		if ($setting_helper->server_automation == "A2(automation-2)") {
			$server = "http://192.186.146.246/";
		}

		$dt = Carbon::now()->setTimezone('Asia/Jakarta');		
		for ($i=1;$i<=20;$i++) {
			$logs .= "<tr>";
			$logs .= "<td>".$dt->toDateString()." ".str_pad(strval($dt->hour), 2, "0", STR_PAD_LEFT).":00:00"."</td>";
			

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."unfollow.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."follow.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."like.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."comment.txt";
			$ch = curl_init($file_server);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				$logs .= "<td>".file_get_contents($file_server)."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);
			
			$logs .= "</tr>";
			
			
			$dt->subHour();
		}

		
		
		// $setting_counters = SettingCounter::where("setting_id","=",Request::input('id'))
												// ->orderBy("created","desc")
												// ->get();
		// foreach($setting_counters as $setting_counter) {
			// $logs .= $setting_counter->created."<br> ".$setting_counter->description;
			// $logs .= "<br><br>";
			// $counter +=1;
			// if ($counter>3) {break;}
		// }
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
	/**
	 * Show Setting Page.
	 *
	 * @return Response
	 */
	public function automation_daily($search="")
	{
    $user = Auth::user();
		
								
		return View::make('admin.setting-automation-daily.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                  ));
	}

  public function load_automation_daily()
  {
		$admin = Auth::user();
		if (Request::input('keyword')=="") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  } else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("settings.insta_username","like","%".Request::input('keyword')."%")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}
					
			
    return view('admin.setting-automation-daily.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                  'day'=>intval(date("d", intval(Request::input('from')))) - 1 ,
                ));
  }
  
	public function pagination_automation_daily()
  {
		if (Request::input('keyword')=="") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  } else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("settings.insta_username","like","%".Request::input('keyword')."%")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}


    return view('admin.setting-automation-daily.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	
}
