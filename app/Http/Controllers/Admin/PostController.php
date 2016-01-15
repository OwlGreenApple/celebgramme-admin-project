<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;

use View,Auth,Request,DB,Carbon,Excel;

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
		$count_post = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->count();
    return View::make('admin.auto-manage.index')->with(
                  array(
                    'user'=>$user,
                    'count_post'=>$count_post,
                  ));
  }

  public function load_auto_manage()
  {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
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
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->paginate(15);
    
                              
    return view('admin.auto-manage.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function update_auto_manage($id)
  {
    $post = Post::find($id);    
    $post->type = "success";
    $post->save();

    $setting_temp = Setting::find($post->setting_id);
    $setting_real = Setting::where("insta_username","=",$setting_temp->insta_username)->where("type","=","real")->first();
    $arr_temp = $setting_temp->toArray();
    unset($arr_temp['id']);unset($arr_temp['type']);
    $setting_real->update($arr_temp);

    return "success";
  }

  public function update_error_cred($id)
  {
    $setting_temp = Setting::find($id);
    $setting_temp->error_cred = true;
    $setting_temp->status = "stopped";
    $setting_temp->save();

    $setting_real = Setting::where('insta_username','=',$setting_temp->insta_username)->where('type','=','real')->first();
    $setting_real->error_cred = true;
    $setting_real->status = "stopped";
    $setting_real->save();

		$user = User::find($setting_temp->user_id);
    $emaildata = [
        'user' => $user,
        'password' => $string,
    ];
    Mail::queue('emails.error-cred', $emaildata, function ($message) use ($user) {
      $message->from('no-reply@celebgramme.com', 'Celebgramme');
      $message->to($user->email);
      $message->subject('[Celebgramme] Welcome to celebgramme.com');
    });

    return "success";
  }

  public function create_excel($string,$stringby)
  {
		$arr = explode(',', $string);
		Excel::create('Filename', function($excel) use ($arr,$stringby) {
      $excel->sheet('keywords', function($sheet)use ($arr,$stringby)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data, $stringby
					));
				}
      });

		})->export('csv');		
	}

}
