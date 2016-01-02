<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;

use View,Auth,Request,DB,Carbon,Mail,Validator;

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

  public function give_bonus()
  {
    $arr["type"] = "success";
    $arr["id"] = Request::input("user-id");
    $arr["action"] = Request::input("action");
    $user=User::find(Request::input("user-id"));
    if (Request::input("action")=="auto") {
      $user->active_auto_manage += (Request::input("active-days") * 86400) + (Request::input("active-hours") * 3600) + (Request::input("active-minutes") * 60);
      if ($user->active_auto_manage < 0 ) {
        $user->active_auto_manage = 0;
      }
      $t = $user->active_auto_manage;
      $days = floor($t / (60*60*24));
      $hours = floor(($t / (60*60)) % 24);
      $minutes = floor(($t / (60)) % 60);
      $seconds = floor($t  % 60);
      $arr["view"] = $days." days ".$hours." hours ".$minutes." minutes ".$seconds."seconds";
    }
    if (Request::input("action")=="daily") {
      $user->balance += Request::input("daily-likes");
      $arr["view"] = $user->balance;
    }
    $user->save();
    return $arr;
  }


  public function add_member()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add member berhasil dilakukan";

    $data = array (
      "email" => Request::input("email"),
    );
    $validator = Validator::make($data, [
      'email' => 'required|email|max:255|unique:users',
    ]);
    if ($validator->fails()){
      $arr["type"] = "error";
      $arr["message"] = "Email sudah terdaftar atau tidak valid";
      return $arr;
    }

    $karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
    $string = '';
    for ($i = 0; $i < 8 ; $i++) {
      $pos = rand(0, strlen($karakter)-1);
      $string .= $karakter{$pos};
    }

    $user = new User;
    $user->email = Request::input("email");
    $user->password = bcrypt($string);
    $user->fullname = Request::input("fullname");
    $user->type = "confirmed-email";
    $user->active_auto_manage = Request::input("member-days") * 86400;
    $user->save();

    $emaildata = [
        'user' => $user,
        'password' => $string,
    ];
    Mail::queue('emails.create-user', $emaildata, function ($message) use ($user) {
      $message->from('no-reply@celebgramme.com', 'Celebgramme');
      $message->to($user->email);
      $message->subject('[Celebgramme] Welcome to celebgramme.com');
    });


    return $arr;
  }


}
