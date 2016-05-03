<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Meta;
use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\PostLog;
use Celebgramme\Models\Setting;
use Celebgramme\Models\SettingMeta; 
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\TemplateEmail;

use View,Auth,Request,DB,Carbon,Excel,Mail;

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
   * Show auto manage page.
   *
   * @return Response
   */
  public function auto_manage()
  {
    $user = Auth::user();
    $admin = User::where("type","=","admin")->get();
		$count_post = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->count();
		$filenames = Meta::where("meta_name","=","fl_name")->get();
		$template = TemplateEmail::all();
    return View::make('admin.auto-manage.index')->with(
                  array(
                    'user'=>$user,
                    'admin'=>$admin,
                    'count_post'=>$count_post,
                    'filenames'=>$filenames,
                    'templates'=>$template,
                  ));
  }

  public function load_auto_manage()
  {
		if (Request::input('keyword') == "" ) {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred","settings.last_user")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->paginate(15);
		} else {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
						 ->where("settings.insta_username","like",Request::input('keyword')."%")
             ->orderBy('posts.updated_at', 'asc')
             ->paginate(15);
		}
		
		$count_post = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->count();
						 
    return view('admin.auto-manage.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                  'postUpdate'=>$count_post,
                ));
  }
  
  public function pagination_auto_manage()
  {
		if (Request::input('keyword') == "" ) {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             //->join("link_users_settings","link_users_settings.setting_id","=","settings.id")
             //->join("users","users.id","=","link_users_settings.user_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
             ->orderBy('posts.updated_at', 'asc')
             ->paginate(15);
		} else {
      $arr = Post::join("settings","settings.id","=","posts.setting_id")
             ->select("posts.*","settings.insta_username","settings.insta_password","settings.error_cred")
             ->where("posts.type","=","pending")
						 ->where("settings.insta_username","like",Request::input('keyword')."%")
             ->orderBy('posts.updated_at', 'asc')
             ->paginate(15);
		}
    return view('admin.auto-manage.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function update_auto_manage($id)
  {
		$user = Auth::user();
    $post = Post::find($id);    
    $post->type = "success";
    $post->save();

    $setting_temp = Setting::find($post->setting_id);
    $setting_real = Setting::where("insta_user_id","=",$setting_temp->insta_user_id)->where("type","=","real")->first();
    $arr_temp = $setting_temp->toArray();
    unset($arr_temp['id']);unset($arr_temp['type']);
    $setting_real->update($arr_temp);

		//log 
		$dt = Carbon::now();
    $postlog = new PostLog;
    $postlog->insta_username = $setting_temp->insta_username;
    $postlog->admin = $user->fullname;
    $postlog->description = $post->description;
    $postlog->created = $dt->toDateTimeString();
    $postlog->server = SettingMeta::getMeta($post->setting_id,"fl_filename");
    $postlog->save();

		if ( ($setting_temp->status=="deleted") && ($setting_real->status=="deleted") ) {
			$setting_temp->delete();
			$delete_setting_real = Setting::find($setting_real->id)->delete();
		}
		
    return "success";
  }

  public function update_status_admin($id)
  {
		$user = Auth::user();
    $post = Post::find($id);    
    $post->status_admin = $user->id;
    $post->save();
		
    return "success";
  }
	
  public function update_fl_filename()
  {
		SettingMeta::createMeta("fl_filename",Request::input("fl-filename"),Request::input("setting-id"));
		
		$arr["id"] = Request::input("setting-id");
		$arr["type"] = "success";
		$arr["filename"] = Request::input("fl-filename");
		return $arr;
	}
	
  public function send_email_member()
  {
    $setting_temp = Setting::where('insta_username','=',Request::input("igaccount"))->where('type','=','temp')->first();
    $setting_temp->error_cred = true;
    $setting_temp->status = "stopped";
    $setting_temp->save();

    $setting_real = Setting::where('insta_user_id','=',$setting_temp->insta_user_id)->where('type','=','real')->first();
    $setting_real->error_cred = true;
    $setting_real->status = "stopped";
    $setting_real->save();

		$text = trim(Request::input("message-email")); // remove the last \n or whitespace character
		$text = nl2br($text); // insert <br /> before \n 		
		
	  $email = Request::input("sender");
		$title = Request::input("title-email");
    $emaildata = [
        'content' => $text,
    ];
    Mail::queue('emails.content', $emaildata, function ($message) use ($email,$title) {
      $message->from('no-reply@celebgramme.com', 'Celebgramme');
      $message->to($email);
      $message->subject($title);
    });

		return "success";
	}
	
  public function load_template_email()
  {
		$arr["type"]="success";
		
		$template = TemplateEmail::find(Request::input("id"));
		
		$arr["title"] = $template->title;
		$message = str_replace("#igaccount",Request::input("igaccount"),$template->message);
		$message = str_replace("#name",Request::input("name"),$message);
		$arr["message"] = $message;
		return $arr;
	}
	
  public function update_error_cred($id)
  {
    $setting_temp = Setting::find($id);
    $setting_temp->error_cred = true;
    $setting_temp->status = "stopped";
    $setting_temp->save();

    $setting_real = Setting::where('insta_user_id','=',$setting_temp->insta_user_id)->where('type','=','real')->first();
    $setting_real->error_cred = true;
    $setting_real->status = "stopped";
    $setting_real->save();

		$user = User::find($setting_temp->last_user);
    $emaildata = [
        'user' => $user,
        'insta_username' => $setting_temp->insta_username,
    ];
    Mail::queue('emails.error-cred', $emaildata, function ($message) use ($user) {
      $message->from('no-reply@celebgramme.com', 'Celebgramme');
      $message->to($user->email);
      $message->subject('[Celebgramme] Error Login Instagram Account');
    });

    return "success";
  }

  public function create_excel($string,$stringby,$username="No username")
  {
		$arr = explode(';', $string);
		Excel::create(date("F j, Y, g:i a")." ".$username." ".$stringby, function($excel) use ($arr,$stringby) {
      $excel->sheet('keywords', function($sheet)use ($arr,$stringby)  {
				foreach ($arr as $data) { 
					if ($stringby=="-") {
						$sheet->appendRow(array(
								$data
						));
					} else {
						$sheet->appendRow(array(
								$data, $stringby
						));
					}
				}
      });

		})->download('csv');
	}
	
	public function create_excel_all($setting_id)
	{
		$setting = Setting::find($setting_id);
		Excel::create('Filename', function($excel) use ($setting) {
      $excel->sheet('keywords', function($sheet)use ($setting)  {
					$sheet->appendRow(array( "insta username : ".$setting->insta_username ));
					$sheet->appendRow(array( "insta password : ".$setting->insta_password ));
					$sheet->appendRow(array( "Status follow unfollow : ".$setting->status_follow_unfollow ));
					$sheet->appendRow(array( "Status Like : ".$setting->status_like ));
					$sheet->appendRow(array( "Status Comment : ".$setting->status_comment ));
					$sheet->appendRow(array( "Activity : ".$setting->activity ));
					$sheet->appendRow(array( "Activity speed : ".$setting->activity_speed ));
					$sheet->appendRow(array( "Comments : ".$setting->comments ));
					$sheet->appendRow(array( "Hashtags : ".$setting->hashtags ));
					$sheet->appendRow(array( "Username : ".$setting->username ));
					$sheet->appendRow(array( "Media Source : ".$setting->media_source ));
					$sheet->appendRow(array( "Media Age : ".$setting->media_age ));
					$sheet->appendRow(array( "Media Type : ".$setting->media_type ));
					$sheet->appendRow(array( "Min like media : ".$setting->min_likes_media ));
					$sheet->appendRow(array( "Max like media : ".$setting->max_likes_media ));
					$sheet->appendRow(array( "Dont comment same user : ".$setting->dont_comment_su ));
					$sheet->appendRow(array( "Follow source : ".$setting->follow_source ));
					$sheet->appendRow(array( "Dont follow same user : ".$setting->dont_follow_su ));
					$sheet->appendRow(array( "Dont follow private user : ".$setting->dont_follow_pu ));
					$sheet->appendRow(array( "Unfollow source : ".$setting->unfollow_source ));
					$sheet->appendRow(array( "Unfollow who dont follow me : ".$setting->unfollow_wdfm ));
					$sheet->appendRow(array( "Unfollow who usernames whitelist : ".$setting->usernames_whitelist ));
					$sheet->appendRow(array( "Status : ".$setting->status ));
      });
		})->download('txt');
	}
	
	public function create_excel_hashtags($setting_id,$stringby)
	{
		$setting = Setting::find($setting_id);
		$string = $setting->hashtags;
		$arr = explode(';', $string);
		Excel::create(date("F j, Y, g:i a")." ".$setting->insta_username." ".$stringby, function($excel) use ($arr,$stringby) {
      $excel->sheet('keywords', function($sheet)use ($arr,$stringby)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data, $stringby
					));
				}
      });
		})->download('csv');
	}
	
	public function create_excel_usernames($setting_id,$stringby)
	{
		$setting = Setting::find($setting_id);
		$string = $setting->username;
		$arr = explode(';', $string);
		Excel::create(date("F j, Y, g:i a")." ".$setting->insta_username." ".$stringby, function($excel) use ($arr,$stringby) {
      $excel->sheet('keywords', function($sheet)use ($arr,$stringby)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data, $stringby
					));
				}
      });
		})->download('csv');
	}
	
	public function create_excel_comments($setting_id)
	{
		$setting = Setting::find($setting_id);
		$string = $setting->comments;
		$arr = explode(';', $string);
		Excel::create(date("F j, Y, g:i a")." ".$setting->insta_username." "."comment", function($excel) use ($arr) {
      $excel->sheet('keywords', function($sheet)use ($arr)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data
					));
				}
      });
		})->download('csv');
	}

	
	/**
	 * Show bpv ranking page.
	 *
	 * @return Response
	 */
	public function log_post()
	{
    $user = Auth::user();
		return View::make('admin.log-post.index')->with(
                  array(
                    'user'=>$user,
                  ));
	}

  public function load_log_post()
  {
    if (Request::input('keyword')=="") {
      $arr = PostLog
             ::where('created','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('created','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orderBy('created', 'desc')
             ->paginate(15);
    } else {
      $arr = PostLog
             ::where('created','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('created','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
						 ->where(function ($query){
								$query->where('insta_username','like','%'.Request::input('keyword').'%')
								->orWhere('admin','like','%'.Request::input('keyword').'%');
						 })
             ->orderBy('created', 'desc')
             ->paginate(15);
    }
    
    return view('admin.log-post.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_log_post()
  {
    if (Request::input('keyword')=="") {
      $arr = PostLog
             ::where('created','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('created','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
             ->orderBy('created', 'desc')
             ->paginate(15);
    } else {
      $arr = PostLog
             ::where('created','>=',date("Y-m-d", intval(Request::input('from')))." 00:00:00")
             ->where('created','<=',date("Y-m-d", intval(Request::input('to')))." 23:59:59")
						 ->where(function ($query){
								$query->where('insta_username','like','%'.Request::input('keyword').'%')
								->orWhere('admin','like','%'.Request::input('keyword').'%');
						 })
             ->orderBy('created', 'desc')
             ->paginate(15);
    }
    
    return view('admin.log-post.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	
}
