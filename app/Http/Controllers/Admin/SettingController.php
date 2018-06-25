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
use Celebgramme\Models\Category;
use Celebgramme\Models\SettingLog;
use Celebgramme\Models\Account;
use Celebgramme\Models\ViewProxyUses;
use Celebgramme\Models\UserSetting;

use Celebgramme\Helpers\GlobalHelper;

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
		/*$availableProxy = Proxies::leftJoin("setting_helpers","setting_helpers.proxy_id","=","proxies.id")
								->select("proxies.id","proxies.proxy","proxies.cred","proxies.port","proxies.auth",DB::raw("count(proxies.id) as total"))
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
			
			$total_proxy_celebpost_used = Account::where("proxy_id","<>",0)->count();
			if ($total_proxy_celebpost_used + $data->total < 5) {
				$arrAvailableProxy[] = $dataNew;	
			}
		}*/
		$arrAvailableProxy = array();
		$availableProxy = ViewProxyUses::select("id","proxy","cred","port","auth",DB::raw(									"sum(count_proxy) as countP"))
											->groupBy("id","proxy","cred","port","auth")
											->orderBy("countP","asc")
											->having('countP', '<', 1)
											->get();
		foreach($availableProxy as $data) {
			$check_proxy = Proxies::find($data->id);
			if ($check_proxy->is_error == 0){
				$dataNew = array();
				// $dataNew[] = $data->id;
				$dataNew["id"] = $data->id;
				if ($data->auth) {
					$dataNew["value"] = $data->proxy.":".$data->port.":".$data->cred;
				} else {
					$dataNew["value"] = $data->proxy.":".$data->port;
				}
				$arrAvailableProxy[] = $dataNew;	
			}
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
								/* leftJoin('setting_metas', function ($join) {
										$join->on('settings.id', '=', 'setting_metas.setting_id');
								})							
							 ->*/leftJoin("users","users.id","=","settings.user_id")
							 ->select("settings.*")
							 // ->where('setting_metas.meta_name', '=', "fl_filename")
							 ->where("settings.type","=","temp")
							 ->where(function ($query){
								 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
								 // ->orWhere("meta_value","like","%".Request::input('keyword')."%")
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
				
				//change yang dicelebpost juga 
				$setting = Setting::find(Request::input("setting-id"));
				$account = Account::where("username","=",$setting->insta_username)->first();
				if (!is_null($account)) {
					$account->proxy_id = Request::input("hiddenIdProxy");
					$account->save();
				}
				
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
		$settingHelper->cookies = "";
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
		$categories = Category::all();
		
		$strCategory = "";
		foreach ($categories as $category) {
			$strCategory .= json_encode(
								array(
									"class"=>strtolower($category->categories),
									"value"=>strtolower($category->name),
									"name"=>ucfirst($category->name),
								)).",";
		}
		
		$strClassCategory = "";
		$groupCategories = Category::groupBy('categories')->get();
		foreach ($groupCategories as $groupCategory) {
			$strClassCategory .= json_encode(
								array(
									"value"=>strtolower($groupCategory->categories),
									"label"=>ucfirst($groupCategory->categories),
								)).",";
		}
								
								
		return View::make('admin.setting-automation.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                    'strCategory'=>$strCategory,
                    'strClassCategory'=>$strClassCategory,
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
	  } 
		if (Request::input('keyword')=="update-identity") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("status","=","started")
					->where("identity","=","none")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}
		else {
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
	  } 
		if (Request::input('keyword')=="update-identity") {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("status","=","started")
					->where("identity","=","none")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}
		else {
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
		
		if ($setting_helper->server_automation == "AA1(automation-1)") {
			$file_server = "http://185.225.104.62/";
		}
		if ($setting_helper->server_automation == "AA2(automation-2)") {
			$file_server = "http://185.206.83.2/";
		}
		if ($setting_helper->server_automation == "AA3(automation-3)") {
			$file_server = "http://185.225.104.57/";
		}
		if ($setting_helper->server_automation == "AA4(automation-4)") {
			$file_server = "http://185.206.83.5/";
		}
		if ($setting_helper->server_automation == "AA5(automation-5)") {
			$file_server = "http://185.225.104.54/";
		}
		if ($setting_helper->server_automation == "AA6(automation-6)") {
			$file_server = "http://185.206.82.66/";
		}
		if ($setting_helper->server_automation == "AA7(automation-7)") {
			$file_server = "http://185.225.104.51/";
		}
		if ($setting_helper->server_automation == "AA8(automation-8)") {
			$file_server = "http://185.206.82.69/";
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
		
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
	public function get_logs_automation_daily() {
		$logs = "";
		$counter =1;
		
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting = Setting::find(Request::input('id'));
		
		if ($setting_helper->server_automation == "AA1(automation-1)") {
			$server = "http://185.225.104.62/";
		}
		if ($setting_helper->server_automation == "AA2(automation-2)") {
			$server = "http://185.206.83.2/";
		}
		if ($setting_helper->server_automation == "AA3(automation-3)") {
			$server = "http://185.225.104.57/";
		}
		if ($setting_helper->server_automation == "AA4(automation-4)") {
			$server = "http://185.206.83.5/";
		}
		if ($setting_helper->server_automation == "AA5(automation-5)") {
			$server = "http://185.225.104.54/";
		}
		if ($setting_helper->server_automation == "AA6(automation-6)") {
			$server = "http://185.206.82.66/";
		}
		if ($setting_helper->server_automation == "AA7(automation-7)") {
			$server = "http://185.225.104.51/";
		}
		if ($setting_helper->server_automation == "AA8(automation-8)") {
			$server = "http://185.206.82.69/";
		}

		$dt = Carbon::now()->setTimezone('Asia/Jakarta');		
		for ($i=1;$i<=14;$i++) {
			$logs .= "<tr>";
			$logs .= "<td>".$dt->toDateString()."</td>";
			

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."unfollow.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."follow.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."like.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."comment.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);
			
			$logs .= "</tr>";
			
			
			$dt->subDay();
		}
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}

	public function get_logs_automation_hourly() {
		$logs = "";
		$counter =1;
		
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting = Setting::find(Request::input('id'));
		
		if ($setting_helper->server_automation == "AA1(automation-1)") {
			$server = "http://185.225.104.62/";
		}
		if ($setting_helper->server_automation == "AA2(automation-2)") {
			$server = "http://185.206.83.2/";
		}
		if ($setting_helper->server_automation == "AA3(automation-3)") {
			$server = "http://185.225.104.57/";
		}
		if ($setting_helper->server_automation == "AA4(automation-4)") {
			$server = "http://185.206.83.5/";
		}
		if ($setting_helper->server_automation == "AA5(automation-5)") {
			$server = "http://185.225.104.54/";
		}
		if ($setting_helper->server_automation == "AA6(automation-6)") {
			$server = "http://185.206.82.66/";
		}
		if ($setting_helper->server_automation == "AA7(automation-7)") {
			$server = "http://185.225.104.51/";
		}
		if ($setting_helper->server_automation == "AA8(automation-8)") {
			$server = "http://185.206.82.69/";
		}

		$dt = Carbon::now()->setTimezone('Asia/Jakarta');		
		for ($i=1;$i<=20;$i++) {
			$logs .= "<tr>";
			$logs .= "<td>".$dt->toDateString()." ".str_pad(strval($dt->hour), 2, "0", STR_PAD_LEFT).":00:00"."</td>";
			

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."unfollow.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."follow.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."like.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);

			$file_server = $server."hourly-action-counter/".$setting->insta_username."/".strval($dt->day)."/".strval($dt->hour)."/"."comment.txt";
			$ch = curl_init($file_server);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
				// $logs .= "<td>".file_get_contents($file_server)."</td>";	
				$logs .= "<td>".$content."</td>";	
			} else {
				$logs .= "<td> 0 </td>";
			}
			curl_close($ch);
			
			$logs .= "</tr>";
			
			
			$dt->subHour();
		}

		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
	public function get_logs_automation_error() {
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
									"Cookie: foo=bar\r\n"
			)
		);

		$context = stream_context_create($opts);
		
		
		$logs = "";
		$counter =1;
		
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');		
		if (Request::input('server')== "0") {
			$settings = Setting::
				join("setting_helpers","setting_helpers.setting_id","=","settings.id")
				->where("type","=","temp")
				->where("status","=","started")
				->orderBy('setting_helpers.server_automation', 'asc')
				->get();
		} else {
			$settings = Setting::
				join("setting_helpers","setting_helpers.setting_id","=","settings.id")
				->where("type","=","temp")
				->where("status","=","started")
				->where("setting_helpers.server_automation","=",Request::input('server'))
				->orderBy('setting_helpers.server_automation', 'asc')
				->get();
		}
			
    foreach ($settings as $setting) {					
			if ($setting->server_automation == "AA1(automation-1)") {
				$server = "http://185.225.104.62/";
			}
			if ($setting->server_automation == "AA2(automation-2)") {
				$server = "http://185.206.83.2/";
			}
			if ($setting->server_automation == "AA3(automation-3)") {
				$server = "http://185.225.104.57/";
			}
			if ($setting->server_automation == "AA4(automation-4)") {
				$server = "http://185.206.83.5/";
			}
			if ($setting->server_automation == "AA5(automation-5)") {
				$server = "http://185.225.104.54/";
			}
			if ($setting->server_automation == "AA6(automation-6)") {
				$server = "http://185.206.82.66/";
			}
			if ($setting->server_automation == "AA7(automation-7)") {
				$server = "http://185.225.104.51/";
			}
			if ($setting->server_automation == "AA8(automation-8)") {
				$server = "http://185.206.82.69/";
			}
			
			$unfollow_counter = 0; $follow_counter = 0; $like_counter = 0; $comment_counter = 0;

			
		try {
			
			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."unfollow.txt";
			if (filter_var($file_server, FILTER_VALIDATE_URL) === FALSE) { } else {
				$ch = curl_init($file_server);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
					// $unfollow_counter = file_get_contents($file_server,false,$context);	
					$unfollow_counter = $content;	
				} else {
					// $unfollow_counter = 0;
				}
				curl_close($ch);
			}

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."follow.txt";
			if (filter_var($file_server, FILTER_VALIDATE_URL) === FALSE) { } else {
				$ch = curl_init($file_server);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
					// $follow_counter = file_get_contents($file_server,false,$context);	
					$follow_counter = $content;	
				} else {
					// $follow_counter = 0;
				}
				curl_close($ch);
			}

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."like.txt";
			if (filter_var($file_server, FILTER_VALIDATE_URL) === FALSE) { } else {
				$ch = curl_init($file_server);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
					// $like_counter = file_get_contents($file_server,false,$context);	
					$like_counter = $content;	
				} else {
					// $like_counter = 0;
				}
				curl_close($ch);
			}

			$file_server = $server."daily-action-counter/".$setting->insta_username."/".strval($dt->day)."/"."comment.txt";
			if (filter_var($file_server, FILTER_VALIDATE_URL) === FALSE) { } else {
				$ch = curl_init($file_server);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
					// $comment_counter = file_get_contents($file_server,false,$context);	
					$comment_counter = $content;	
				} else {
					// $comment_counter = 0;
				}
				curl_close($ch);
			}
			
			$desc = ""; $logs_temp = "";

			if ( ( ($unfollow_counter==0) && ($follow_counter==0) && ($like_counter==0) && ($comment_counter==0) ) || ( substr($setting->cookies, 0, 5) == "error")) {
			
				$logs_temp .= "<tr>";
				$logs_temp .= "<td>".$setting->insta_username."</td>";
				
				if ($setting->cookies=="error login status :check") {
					$logs_temp .= "<td>Error Password Reset</td>";
				} else
				if ($setting->cookies=="error csrf status : new") {
					$logs_temp .= "<td>Error Konfirmasi Telepon / Email</td>";
				} else
				if ($setting->cookies=="") {
					$logs_temp .= "<td>OFF</td>";
				} else {
					$logs_temp .= "<td>".$setting->cookies."</td>";
				}
			
				if ( ($unfollow_counter==0) && ($follow_counter==0) && ($like_counter==0) && ($comment_counter==0) ) {
					$desc .= "Error No Activity";
				}
				if ( substr($setting->cookies, 0, 5) == "error") {
					$desc .= " Error Cookies";
				}
				
				$logs_temp .= "<td>".$desc."</td>";
				$logs_temp .= "</tr>";
				$logs .= $logs_temp;
			}
			
		} catch (Exception $e) {
				// echo 'Caught exception: ',  $e->getMessage(), "\n";
				$logs .= "<tr><td colspan=3>".$setting->insta_password."</td></tr>";
				continue;
		}
			
			
		}

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
					->where("status","=","started")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  }
		else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("status","=","started")
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
					->where("status","=","started")
					->orderBy('settings.id', 'asc')
					->paginate(15);
	  } 
		else {
			$arr = Setting::
					join("setting_helpers","setting_helpers.setting_id","=","settings.id")
					->where("type","=","temp")
					->where("status","=","started")
					->where("settings.insta_username","like","%".Request::input('keyword')."%")
					->orderBy('settings.id', 'asc')
					->paginate(15);
		}


    return view('admin.setting-automation-daily.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function refresh_account() {
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting_helper->is_refresh = 1 ;
		$setting_helper->save();
		
		
		$arr["logs"] = "";
		$arr["type"] = "success";
		return $arr;
	}
	
	public function refresh_auth() {
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting_helper->cookies = "" ;
		$setting_helper->save();
		
		// $setting = Setting::find(Request::input('id'));
		// if (!is_null($setting)) {
			// $user_setting = UserSetting::where("username",strtolower($setting->insta_username))->first();
			// if (!is_null($user_setting)) {
				// $user_setting->delete();
			// }
		// }
		
		//assign proxy ulang
		$ssetting = serialize(Setting::find(Request::input('id')));
		GlobalHelper::clearProxy($ssetting,"change");
		
		$arr["logs"] = "";
		$arr["type"] = "success";
		return $arr;
	}
	
	
	public function delete_action() {
		$setting_helper = SettingHelper::where("setting_id","=",Request::input('id'))->first();
		$setting_helper->is_refresh = 1 ;
		$setting_helper->is_delete_action = 1 ;
		$setting_helper->save();
		
		
		$arr["logs"] = "";
		$arr["type"] = "success";
		return $arr;
	}
	
	public function update_identity() {
		$setting_helper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
		if (!is_null($setting_helper)) {
			$setting_helper->identity = Request::input("identity");
			$setting_helper->save();
		}
		$arr["type"]="success";
		$arr["message"]="identity berhasil diupdate";
		$arr["identity"]=Request::input("identity");
		return $arr;
	}

	public function update_target() {
		$setting_helper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
		if (!is_null($setting_helper)) {
			$setting_helper->target = Request::input("target");
			$setting_helper->save();
		}
		$setting = Setting::find(Request::input("setting-id"));
		$setting->hashtags_auto = "";
		
		$arr = explode(";",Request::input("target"));
		$counter = 1;
		foreach($arr as $data_arr) {
			$category = Category::where("name","like","%".$data_arr."%")->first();
			if ($counter<count($arr)) {
				$setting->hashtags_auto .= $category->hashtags.";";
			} else {
				$setting->hashtags_auto .= $category->hashtags;
			}
			$counter += 1;
		}

		$setting->save();
		$arr["type"]="success";
		$arr["message"]="target berhasil diupdate";
		$arr["target"]=Request::input("target");
		return $arr;
	}

	public function load_setting_logs() {
		$logs = "";
		$counter =1;
		
		$settingLogs = SettingLog::where("setting_id","=",Request::Input("id"))->orderBy('id', 'desc')->get();
		foreach($settingLogs as $settingLog){
			$logs .= "<tr><td>".$settingLog->created."</td><td>".$settingLog->status."</td></tr>";
		}
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
	public function change_method_automation() {
		$setting = Setting::find(Request::input("setting-id"));
		$setting->method = Request::input("method-automation");
		$setting->save();
		
		$arr["type"] = "success";
		return $arr;
	}

	/**
	 * Show Log Setting Page.
	 *
	 * @return Response
	 */
	public function log_index($search="")
	{
    $user = Auth::user();
		
		
								
		return View::make('admin.log-setting.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                  ));
	}

  public function log_load_setting()
  {
		$admin = Auth::user();
		if (Request::input('keyword')=="") {
			$arr = Setting::join("users","users.id","=","settings.user_id")
						 ->join("user_logs","users.email","=","user_logs.email")
						 ->select("users.email","description","settings.status","user_logs.created","settings.insta_username")
						 ->where("settings.type","=","temp")
						 ->where("description","like","%Success add%")
						 ->paginate(15);
		}
		else {
			$arr = Setting::join("users","users.id","=","settings.user_id")
						 ->join("user_logs","users.email","=","user_logs.email")
						 ->select("users.email","description","settings.status","user_logs.created","settings.insta_username")
						 ->where("settings.type","=","temp")
						 ->where("description","like","%Success add%")
						 ->where(function ($query){
							 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
							 // ->orWhere("meta_value","like","%".Request::input('keyword')."%")
							 ->orWhere("users.email","like","%".Request::input('keyword')."%");
						 })
						 ->paginate(15);
		}
			
    return view('admin.log-setting.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function log_pagination_setting()
  {
		if (Request::input('keyword')=="") {
			$arr = Setting::join("users","users.id","=","settings.user_id")
						 ->join("user_logs","users.email","=","user_logs.email")
						 ->where("settings.type","=","temp")
						 ->where("description","like","%Success add%")
						 ->paginate(15);
		}
		else {
			$arr = Setting::join("users","users.id","=","settings.user_id")
						 ->join("user_logs","users.email","=","user_logs.email")
						 ->where("settings.type","=","temp")
						 ->where("description","like","%Success add%")
						 ->where(function ($query){
							 $query->orWhere("insta_username","like","%".Request::input('keyword')."%")
							 // ->orWhere("meta_value","like","%".Request::input('keyword')."%")
							 ->orWhere("users.email","like","%".Request::input('keyword')."%");
						 })
						 ->paginate(15);
		}
			
    return view('admin.log-setting.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	
  public function start_account()
  {
		$admin = Auth::user();
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');
		$setting_temp = Setting::find(Request::input("id"));
		
		$user = User::find($setting_temp->last_user);
    if ( ($user->active_auto_manage==0) && ((Request::input('action')=='start')) ) {
      $arr["message"]= "Anda tidak dapat menjalankan program, silahkan upgrade waktu anda";
      $arr["type"]= "error";
      return $arr;
    }
		
		if ($setting_temp->is_active) {
			if ($setting_temp->error_cred==1) {
				$url = url('dashboard');
				$arr["message"]= "Anda tidak dapat menjalankan program, silahkan update login credential account anda";
				$arr["type"]= "error";
				return $arr;
			}
			if ( (!$setting_temp->status_auto)&&($setting_temp->status_follow_unfollow=="off")&&($setting_temp->status_like=="off") ) {
				$arr["message"]= "Anda tidak dapat menjalankan program, silahkan pilih aktifitas yang akan dilakukan (follow/like). Jangan lupa di SAVE sesudahnya. ";
				$arr["type"]= "error";
				return $arr;
			}
			$setting_temp->status = "started";
			$setting_temp->start_time = $dt->toDateTimeString();
			$setting_temp->running_time = $dt->toDateTimeString();

			//for automation purpose
			$setting_helper = SettingHelper::where("setting_id","=",$setting_temp->id)->first();
			if (!is_null($setting_helper)) {

				// ONLY for init assign proxy
				if ($setting_helper->proxy_id == 0) {
					$setting_helper->cookies = ""; //trying to fixing error "ubah setting instagram anda"
					$setting_helper->save();
					GlobalHelper::clearProxy(serialize($setting_temp),"new");
				}
			}

			$setting_temp->save();

			//create log 
			$settingLog = new SettingLog;
			$settingLog->setting_id = $setting_temp->id;
			$settingLog->status = "Start setting by admin ".$admin->fullname;
			$settingLog->description = "settings log";
			$settingLog->created = $dt->toDateTimeString();
			$settingLog->save();

		}
		else {
			$arr["message"]= "Pastikan anda telah menambahkan IG account anda terlebih dahulu. Kemudian START kembali ".$setting_temp->insta_username;
			$arr["type"]= "error";
			return $arr;
		}
		
		
		
		$arr["type"] = "success";
		$arr["message"] = "Account berhasil distart";
		return $arr;
	}

}
