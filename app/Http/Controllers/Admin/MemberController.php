<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;

use View,Auth,Request,DB,Carbon;

class MemberController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	



/*
* Access token
*
*/


  /**
   * Show access_token for instagram api.
   *
   * @return Response
   */
  public function access_token()
  {
    $user = Auth::user();
    return View::make('admin.access-token.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }

  public function load_access_token()
  {
      $arr = Setting::where("type","=","temp")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->orderBy('id', 'desc')
             ->paginate(15);

    return view('admin.access-token.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_access_token()
  {
      $arr = Setting::where("type","=","temp")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->orderBy('id', 'desc')
             ->paginate(15);
    
                              
    return view('admin.access-token.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }


  public function update_access_token()
  {
    $setting_temp = Setting::find(Request::input('setting-id'));
    $setting_real = Setting::where("insta_username","=",$setting_temp->insta_username)->where("type","=","real")->first();

    $setting_temp->insta_access_token = Request::input('access_token');
    $setting_temp->save();
    $setting_real->insta_access_token = Request::input('access_token');
    $setting_real->save();

    $arr['type'] = "success";
    $arr['token'] = Request::input('access_token');
    $arr['id'] = Request::input('setting-id');
    return $arr;
  }







/*
* Member all
*
*/


  /**
   * Show Member all page.
   *
   * @return Response
   */
  public function member_all()
  {
    $user = Auth::user();
    $arr = User::where("type","<>","admin")
             ->select(DB::raw("sum(active_auto_manage) as total_time_manage"))
             ->orderBy('id', 'desc')
             ->get();
    return View::make('admin.member-all.index')->with(
                  array(
                    'user'=>$user,
                    'total_auto_manage'=>$arr[0]->total_time_manage,
                  ));
  }

  public function load_member_all()
  {
      $arr = User::where("type","<>","admin")
             ->orderBy('active_auto_manage', 'desc')
             ->paginate(15);

    return view('admin.member-all.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_member_all()
  {
      $arr = User::where("type","<>","admin")
             ->orderBy('active_auto_manage', 'desc')
             ->paginate(15);
    
                              
    return view('admin.member-all.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }





}
