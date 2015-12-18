<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;

use View,Auth,Request,DB,Carbon;

class PostController extends Controller {


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
	 * Show bpv ranking page.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();
		return View::make('admin.history.index')->with(
                  array(
                    'user'=>$user,
                  ));
	}

  public function load_post()
  {
    if (Request::input('username')=="") {
      $arr = RequestModel::join('users', 'users.id', '=', 'requests.user_id')
             ->select("requests.*","users.email","users.fullname","users.phone_number")
             ->where('requests.created_at','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('requests.created_at','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orderBy('requests.created_at', 'desc')
             ->paginate(15);
    } else {
      $arr = RequestModel::join('users', 'users.id', '=', 'requests.user_id')
             ->select("requests.*","users.email","users.fullname")
             ->where('requests.created_at','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('requests.created_at','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orWhere('fullname','like','%'.Request::input('search').'%')
             ->orderBy('requests.created_at', 'desc')
             ->paginate(15);
    }
    
    return view('admin.history.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                  'username'=>Request::input('username'),
                ));
  }
  
	public function pagination_post()
  {
    if (Request::input('username')=="") {
      $arr = RequestModel::join('users', 'users.id', '=', 'requests.user_id')
             ->select("requests.*","users.email","users.fullname")
             ->where('requests.created_at','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('requests.created_at','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orderBy('requests.created_at', 'desc')
             ->paginate(15);
    } else {
      $arr = RequestModel::join('users', 'users.id', '=', 'requests.user_id')
             ->select("requests.*","users.email","users.fullname")
             ->where('requests.created_at','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('requests.created_at','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orWhere('fullname','like','%'.Request::input('search').'%')
             ->orderBy('requests.created_at', 'desc')
             ->paginate(15);
    }
    
                              
    return view('admin.history.pagination')->with(
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





/*
* AUTO MANAGE
*
*/


  /**
   * Show bpv ranking page.
   *
   * @return Response
   */
  public function auto_manage()
  {
    $user = Auth::user();
    return View::make('admin.auto-manage.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }

  public function load_auto_manage()
  {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             ->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'desc')
             ->paginate(15);

    return view('admin.auto-manage.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_auto_manage()
  {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             ->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'desc')
             ->paginate(15);
    
                              
    return view('admin.auto-manage.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }


}
