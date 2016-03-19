<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\Order;
use Celebgramme\Models\Package;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\UserMeta;
use Celebgramme\Models\UserLog;

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
    $setting_real = Setting::where("insta_user_id","=",$setting_temp->insta_user_id)->where("type","=","real")->first();

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
		$orders = Order::where("affiliate","=","1")->
						 where("user_id","=","0");
    return View::make('admin.member-all.index')->with(
                  array(
                    'user'=>$user,
                    'orders'=>$orders,
                    'total_auto_manage'=>$arr[0]->total_time_manage,
                  ));
  }

  public function load_member_all()
  {
		if (Request::input('sort')==1) {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","<>","admin")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","<>","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			}
		} else {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","<>","admin")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","<>","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			}
		}

    return view('admin.member-all.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_member_all()
  {
		if (Request::input('sort')==1) {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","<>","admin")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","<>","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			}
		} else {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","<>","admin")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","<>","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			}
		}
    
                              
    return view('admin.member-all.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function give_bonus()
  {
		$dt = Carbon::now();
		$admin = Auth::user();
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
      $arr["view"] = $days."D ".$hours."H ".$minutes."M ".$seconds."S ";
			
			$user_log = new UserLog;
			$user_log->email = $user->email;
			$user_log->admin = $admin->fullname;
			$user_log->description = "give time to member. ".$days."D ".$hours."H ".$minutes."M ".$seconds."S ";
			$user_log->created = $dt->toDateTimeString();
			$user_log->save();
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
    $arr["orderid"] = Request::input("select-order");

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
    $user->password = $string;
    $user->fullname = Request::input("fullname");
    $user->type = "confirmed-email";
    $user->save();
		
		$order = Order::find(Request::input("select-order"));
		$order->user_id = $user->id;
		$order->save();

		$package = Package::find($order->package_manage_id);
    $user->active_auto_manage = $package->active_days * 86400;
    $user->max_account = $package->max_account;
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

  public function edit_member()
  {
		$dt = Carbon::now();
		$admin = Auth::user();
    $arr["type"] = "success";
    $arr["message"] = "Proses edit member berhasil dilakukan";
		
		$user = User::find(Request::input("user-id"));
		if ($user->email<>Request::input("emailedit")) {
			$data = array (
				"email" => Request::input("emailedit"),
			);
			$validator = Validator::make($data, [
				'email' => 'required|email|max:255|unique:users',
			]);
			if ($validator->fails()){
				$arr["type"] = "error";
				$arr["message"] = "Email sudah terdaftar atau tidak valid";
				return $arr;
			}
		}
		
		$user->email = Request::input("emailedit");
		$user->fullname = Request::input("fullnameedit");
		$user->active_auto_manage = Request::input("member-days") * 86400;
		$user->save();
		
		$user_log = new UserLog;
		$user_log->email = $user->email;
		$user_log->admin = $admin->fullname;
		$user_log->description = "Edit Member. email : ".Request::input("emailedit").", fullname : ".Request::input("fullnameedit").", time : ".Request::input("member-days") * 86400 ."days";
		$user_log->created = $dt->toDateTimeString();
		$user_log->save();
		
    return $arr;
	}
	
  public function edit_member_login_webstame()
	{
    $arr["type"] = "success";
    $arr["message"] = "Proses edit member berhasil dilakukan";

		$user = User::find(Request::input("user-id"));
		$user->test = Request::input("check-login");
		$user->save();

    return $arr;
	}

  public function delete_member()
  {
		$user = User::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }

  /**
   * Show Admin all page.
   *
   * @return Response
   */
  public function admin()
  {
    $user = Auth::user();
		$orders = Order::where("affiliate","=","1")->
						 where("user_id","=","0");
    return View::make('admin.admin-all.index')->with(
                  array(
                    'user'=>$user,
                    'orders'=>$orders,
                  ));
  }

  public function load_admin()
  {
		if (Request::input('sort')==1) {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","=","admin")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","=","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			}
		} else {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","=","admin")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","=","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			}
		}

    return view('admin.admin-all.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_admin()
  {
		if (Request::input('sort')==1) {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","=","admin")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","=","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('created_at', 'desc')
							 ->paginate(15);
			}
		} else {
		  if (Request::input('keyword')=="") {
				$arr = User::where("type","=","admin")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			} else {			
				$arr = User::where("type","=","admin")
							 ->where("email",'like',Request::input('keyword')."%")
							 ->orderBy('active_auto_manage', 'desc')
							 ->paginate(15);
			}
		}
    
                              
    return view('admin.admin-all.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function add_admin()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add member berhasil dilakukan";
    $arr["orderid"] = Request::input("select-order");

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
    $user->password = $string;
    $user->fullname = Request::input("fullname");
    $user->type = "admin";
    $user->save();
		
    $user->active_auto_manage = 86400;
    $user->max_account = 3;
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

  public function edit_admin()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses edit member berhasil dilakukan";
		
		$user = User::find(Request::input("user-id"));
		if ($user->email<>Request::input("emailedit")) {
			$data = array (
				"email" => Request::input("emailedit"),
			);
			$validator = Validator::make($data, [
				'email' => 'required|email|max:255|unique:users',
			]);
			if ($validator->fails()){
				$arr["type"] = "error";
				$arr["message"] = "Email sudah terdaftar atau tidak valid";
				return $arr;
			}
		}
		
		$user->email = Request::input("emailedit");
		$user->fullname = Request::input("fullnameedit");
		$user->active_auto_manage = Request::input("member-days") * 86400;
		$user->save();
		
		$usermeta= UserMeta::createMeta("color",Request::input("member-color"),$user->id);
		
    return $arr;
	}
	
  public function delete_admin()
  {
		$user = User::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }
	
}
