<?php
namespace Celebgramme\Helpers;

use Celebgramme\Models\SettingHelper;
use Celebgramme\Models\Proxies;
use Celebgramme\Models\UserLog;
use Celebgramme\Helpers\GlobalHelper;
use Celebgramme\Models\ViewProxyUses;
use Celebgramme\Models\Account;

use Carbon\Carbon;

use DB, Crypt, App;

class GlobalHelper {

	/**
	 * Destroy a instance.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		$this->childObject  = null;
	}
		
	/*
	*
	*	for change <@mention> at comment
	*
	*/
	public static function str_replace_first($from, $to, $subject)
	{
		$from = '/'.preg_quote($from, '/').'/';

		return preg_replace($from, $to, $subject, 1);
	}

	/*
	*
	*	for clear cookies when error
	*
	*/
	public static function clearCookies($setting_id,$owner) {
		//delete cookie
		// $cookiefile = base_path().'/storage/ig-cookies/'.$owner.'-cookiess.txt';
		// unlink($cookiefile);
		if (file_exists('rm -R '.base_path().'/storage/ig-cookies/'.$owner)) {
			exec('rm -R '.base_path().'/storage/ig-cookies/'.$owner);
		}
		
	
		/*
		* destroy variable 
		*/
		$setting_helper = null; $cookiefile = null; $setting_id = null; $owner = null;
	}

	public static function clearScrape($file_scrape){
		if (file_exists('rm -R '.$file_scrape)) {
			exec('rm -R '.$file_scrape);
		}
		/*
		* destroy variable 
		*/
		$file_scrape = null;
	}
	
	/*
	*
	*	for clear Proxy and assign with new proxy
	*
	*/
	public static function clearProxy($ssetting, $status){
		$setting = unserialize($ssetting);
		$setting_helper = SettingHelper::where("setting_id","=",$setting->id)->first();
		
		//data id yang pake proxy di celebgramme
		$array_clb = array();
		$data_setting_helper = SettingHelper::select('proxy_id')
													 ->where('proxy_id','<>',0)->get();
		foreach($data_setting_helper as $data) {
			$array_clb[] = $data->proxy_id;
		}

		//data id yang pake proxy di celebpost
		$array_clp = array();
		$accounts = Account::select('proxy_id')
								->where('proxy_id','<>',0)->get();
		foreach($accounts as $data) {
			$array_clp[] = $data->proxy_id;
		}

		//data id yang diblacklist
		/*$array_bl = array();
    $proxies = Proxies::where(DB::raw("cast(port as signed)"),">=",9388)
                ->where(DB::raw("cast(port as signed)"),"<=",13388)
                ->get();
    foreach ($proxies as $proxy) {
			$array_bl[] = $proxy->id;
		}*/

		//carikan proxy baru, yang available 
		/*error migration $availableProxy = ViewProxyUses::select("id","proxy","cred","port","auth",DB::raw(	"sum(count_proxy) as countP"))
											->groupBy("id","proxy","cred","port","auth")
											->orderBy("countP","asc")
											->having('countP', '<', 1)
											->get();*/
		$availableProxy = Proxies::
											select('id')
											->whereNotIn('id',$array_clb)
											->whereNotIn('id',$array_clp)
											// ->whereNotIn('id',$array_bl)
											->get();
		$arrAvailableProxy = array();
		foreach($availableProxy as $data) {
			/*error migration $check_proxy = Proxies::find($data->id);
			if ($check_proxy->is_error == 0){
				$dataNew = array();
				$dataNew["id"] = $data->id;
				$arrAvailableProxy[] = $dataNew;	
			}*/
			$dataNew = array();
			$dataNew["id"] = $data->id;
			$arrAvailableProxy[] = $dataNew;	
		}
		if (count($arrAvailableProxy)>0) {
			$proxy_id = $arrAvailableProxy[array_rand($arrAvailableProxy)]["id"];
		} else {
			/*error migration $availableProxy = ViewProxyUses::select("id","proxy","cred","port","auth",DB::raw(									"sum(count_proxy) as countP"))
												->groupBy("id","proxy","cred","port","auth")
												->orderBy("countP","asc")
												->first();
			if (!is_null($availableProxy)) {
				$proxy_id = $availableProxy->id;
			}*/
		}

		if($status=="new"){
			//klo assign baru, cek di celebpost klo uda ada ambil di celebpost.
			$account = Account::where("username","=",$setting->insta_username)
									->first();
			if (!is_null($account)){
				$proxy_id = $account->proxy_id;
			}
		} 

		if (!is_null($setting_helper)) {
			$setting_helper->proxy_id = $proxy_id;
			$setting_helper->save();
		}
    
    //kasi tanda yang di celebpost klo ada.
    $account = Account::where("username","=",$setting->insta_username)
                ->first();
    if (!is_null($account)){
      $account->is_on_celebgramme = 1;
      $account->proxy_id = $proxy_id;
      $account->save();
    }
		
		$arr["proxy_id"] = $proxy_id;
		$full_proxy =  Proxies::find($proxy_id);
		if (!is_null($full_proxy)) {
			$arr["port"] = $full_proxy->port;
			$arr["cred"] = $full_proxy->cred;
			$arr["proxy"] = $full_proxy->proxy;
			$arr["auth"] = $full_proxy->auth;
		}
	
		return $arr;
		
		/*
		*
		* destroy variable 
		*
		*/
		$setting = null; $setting_helper = null; $proxy_id = null; $availableProxy = null; 
		$arrAvailableProxy = null;
	}

	/*
	*
	*	for get array cookie
	*
	*/
	public static function getArrayCookie($ssetting,$type){
		$setting = unserialize($ssetting);
		$flag_error = false; $flag_error1 = false; $flag_error2 = false; 
		$setting_helper = SettingHelper::where("setting_id","=",$setting->id)->first();
		
		//load cookie file 
		$cookiefile = base_path().'/storage/ig-cookies/'.$setting->insta_username.'/'.$type.'-cookiess.txt';
		if (!file_exists($cookiefile)) {
			//check cookie file klo ga exist, copy dari main
			// copy( base_path().'/storage/ig-cookies/'.$setting->insta_username.'/main-cookiess.txt' , $cookiefile);
			copy( base_path().'/storage/ig-cookies/'.$setting->insta_username.'/master-cookiess.txt' , $cookiefile);
		}
		//check cookie, if empty exit;
		$cotext = @file_get_contents($cookiefile);
		if ($cotext == false) {
			if (!is_null($setting_helper)) {
				$setting_helper->cookies = "";
				$setting_helper->save();
			}
			// continue;
			$flag_error1 = true;
		} else {
			if ($cotext == "") {
				if (!is_null($setting_helper)) {
					$setting_helper->cookies = "";
					$setting_helper->save();
				}
				// continue;
				$flag_error1 = true;
			}
		}

		$array_cookie = array(); $session_id=""; $ds_user_id=""; $mid = ""; $csrftoken = ""; 
		if (!$flag_error1) {
			//cookie var handling for parsing to header http
			preg_match('/(sessionid)\\s+(IGSC[^\\s]+)/', $cotext, $id);
			if (count($id)>0){
				$session_id = $id[2];
			} else {
				$flag_error2 = true;
			}
			preg_match('/(ds_user_id)\s(\S*)/', $cotext, $id);
			if (count($id)>0){
				$ds_user_id = $id[2];
			} else {
				$flag_error2 = true;
			}
			preg_match('/(mid)\s(\S*)/', $cotext, $id);
			if (count($id)>0){
				$mid = $id[2];
			} else {
				$flag_error2 = true;
			}
			preg_match('/(csrftoken)\s(\S*)/', $cotext, $id);
			if (count($id)>0){
				$csrftoken = $id[2];
			} else {
				$flag_error2 = true;
			}
			if (!$flag_error2) {
				$array_cookie = array(
					'cookie:mid='.$mid.'; fbm_124024574287414=base_domain=.instagram.com; sessionid='.$session_id.'; s_network=; ds_user_id='.$ds_user_id,
					'origin:https://www.instagram.com',
					'user-agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
					'x-csrftoken:'.$csrftoken,
					'x-instagram-ajax:1',
					'x-requested-with:XMLHttpRequest',
				);
			} else if ($flag_error2) {
				//klo uda error jangan di counter lagi
				if ( ( substr($setting_helper->cookies, 0, 7) == "success") || ($setting_helper->cookies=="") ) {
				// if ( $setting_helper->cookies <> "error cookies" ) {
					GlobalHelper::clearProxy($ssetting,"change");
					// if ( substr($setting_helper->cookies, 0, 5) == "error" ) {
						// $setting_helper->cookies .= ", error cookies";
					// } else {
					$setting_helper->cookies = "error cookies";
					// }
					$setting_helper->save();

					//update number_of_error_cookies 
					$dir = base_path().'/storage/error-cookies/'.$setting->insta_username; 
					if (!file_exists($dir)) {
						mkdir($dir,0755,true);
					}
					$file = $dir.'/number.txt';
					if (!file_exists($file)) {
						$number_of_error_cookies = 0;
					} else {
						$number_of_error_cookies = (int) file_get_contents($file);
					}
					if ( $number_of_error_cookies <= 4 ) {
						$number_of_error_cookies += 1;
					}
					file_put_contents($file, $number_of_error_cookies);
					
					$dt = Carbon::now()->setTimezone('Asia/Jakarta');
					$file = $dir.'/last-error.txt';
					file_put_contents($file, $dt->toDateTimeString());
				}
			}
		}
		
		if ( ($flag_error1) || ($flag_error2) ) {
			$flag_error = true;
		}
		
		return array(
			"array_cookie" => $array_cookie,
			"flag_error" => $flag_error,
			"cookiefile" => $cookiefile,
		);
	}
	
	public static function copyMasterCookies($username){
		$cookiefile = base_path().'/storage/ig-cookies/'.$username.'/master-cookiess.txt';
		copy($cookiefile , base_path().'/storage/ig-cookies/'.$username.'/main-cookiess.txt');
		copy($cookiefile , base_path().'/storage/ig-cookies/'.$username.'/follow-cookiess.txt');
		copy($cookiefile , base_path().'/storage/ig-cookies/'.$username.'/like-cookiess.txt');
		copy($cookiefile , base_path().'/storage/ig-cookies/'.$username.'/comment-cookiess.txt');
	}
	

}

?>
