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
		return View::make('admin.setting.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                    'filenames'=>$filenames,
                    'status_server'=>$status_server,
										'templates'=>$template,
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

	public function update_setting_helper()
	{
		$settingHelper = SettingHelper::where("setting_id","=",Request::input("setting-id"))->first();
		if (is_null($settingHelper)) {
			$settingHelper = new SettingHelper;
		}
		$settingHelper->server = Request::input("name-server");
		$settingHelper->proxy = Request::input("proxy");
		$settingHelper->cred = Request::input("cred");
		$settingHelper->port = Request::input("port");
		$settingHelper->setting_id = Request::input("setting-id");
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

}
