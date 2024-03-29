<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\User;
use Celebgramme\Models\Order;
use Celebgramme\Models\Invoice;
use Celebgramme\Models\Package;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\UserMeta;
use Celebgramme\Models\UserLog;
use Celebgramme\Models\AdminLog;
use Celebgramme\Models\Coupon;
use Celebgramme\Models\TimeLog;
use Celebgramme\Models\Affiliate;
use Celebgramme\Models\Refund;
use Celebgramme\Models\Referral;
use Celebgramme\Models\ViewUserAffiliate;

use Celebgramme\Models\UserCelebpost;

use View,Auth,Hash,Request,DB,Carbon,Mail,Validator, Input, Excel, Config;

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
		$packages = Package::where("package_group","=","auto-manage")
								->orderBy('price', 'asc')->get();
	  $affiliates = Affiliate::all();
    return View::make('admin.member-all.index')->with(
                  array(
                    'user'=>$user,
                    'affiliates'=>$affiliates,
                    'packages'=>$packages,
                    'total_auto_manage'=>$arr[0]->total_time_manage,
                  ));
  }

  public function load_member_all()
  {
		$admin = Auth::user();
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

    /*return view('admin.member-all.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));*/
    $arr2['view'] = (string) view('admin.member-all.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
    $arr2['pagination'] = (string) view('admin.member-all.pagination')->with(
                array(
                  'arr'=>$arr,
                ));

    return $arr2;
  }
  
  public function member_affiliate()
  {
    $user = Auth::user();
    $arr = User::where("type","<>","admin")
             ->where("is_member_rico",1)
             ->select(DB::raw("sum(active_auto_manage) as total_time_manage"))
             ->orderBy('id', 'desc')->get();
    $total_user = User::where("type","<>","admin")
             ->where("is_member_rico",1)
             ->select(DB::raw("sum(active_auto_manage) as total_time_manage"))
             ->orderBy('id', 'desc')->count();
    
    
    $packages = Package::where("package_group","=","auto-manage")
                ->orderBy('price', 'asc')->get();
    $affiliates = Affiliate::all();
    return View::make('admin.member-affiliate.index')->with(
                  array(
                    'user'=>$user,
                    'affiliates'=>$affiliates,
                    'packages'=>$packages,
                    'total_auto_manage'=>$arr[0]->total_time_manage,
                    'total_user' => $total_user,
                  ));
  }

  public function load_member_affiliate()
  {
    $admin = Auth::user();
    if (Request::input('sort')==1) {
      if (Request::input('keyword')=="") {
        $arr = User::where("type","<>","admin")
               ->where("is_member_rico",1)
               ->orderBy('created_at', 'desc')
               ->paginate(15);
      } else {      
        $arr = User::where("type","<>","admin")
               ->where("is_member_rico",1)
               ->where("email",'like',Request::input('keyword')."%")
               ->orderBy('created_at', 'desc')
               ->paginate(15);
      }
    } else {
      if (Request::input('keyword')=="") {
        $arr = User::where("type","<>","admin")
               ->where("is_member_rico",1)
               ->orderBy('active_auto_manage', 'desc')
               ->paginate(15);
      } else {      
        $arr = User::where("type","<>","admin")
               ->where("is_member_rico",1)
               ->where("email",'like',Request::input('keyword')."%")
               ->orderBy('active_auto_manage', 'desc')
               ->paginate(15);
      }
    }

    /*return view('admin.member-all.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));*/
    $arr2['view'] = (string) view('admin.member-affiliate.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
    $arr2['pagination'] = (string) view('admin.member-all.pagination')->with(
                array(
                  'arr'=>$arr,
                ));

    return $arr2;
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
			$user_log->description = "give time to member. ".Request::input("active-days")."D ".Request::input("active-hours")."H ".Request::input("active-minutes")."M ";
			$user_log->created = $dt->toDateTimeString();
			$user_log->save();
    }
    if (Request::input("action")=="daily") {
      $user->balance += Request::input("daily-likes");
      $arr["view"] = $user->balance;
    }
    $user->save();

    $adminlog = new AdminLog;
    $adminlog->user_id = Auth::user()->id;
    $adminlog->description = 'Tambah waktu, '.$user->email.', '.Request::input("active-days")."D ".Request::input("active-hours")."H ".Request::input("active-minutes")."M ";
    $adminlog->save();

    return $arr;
  }


  public function add_member_rico()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add member berhasil dilakukan";


			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-add-rico-member'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			$arr_user=[];
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ( ($row->name=="") && ($row->email=="") )  {
							continue;
						}
						
						$email = str_replace(" ", "", $row->email);
						$data = array (
							"email" => $email,
						);
						$validator = Validator::make($data, [
							'email' => 'required|email|max:255',
						]);
						if ($validator->fails()){
							// $arr["type"] = "error";
							// $arr["message"] = "Email sudah terdaftar atau tidak valid";
							// return $arr;
							continue;
						}


						//create user dicelebgramme
						$user = User::where("email","=",$email)->first();
						$string = '';
						if (is_null($user)) {
							//password
							$karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
							for ($i = 0; $i < 8 ; $i++) {
								$pos = rand(0, strlen($karakter)-1);
								$string .= $karakter{$pos};
							}
							
							$user = new User;
							$user->password = $string;
							$user->email = $email;
							$user->fullname = $row->name;
							$user->type = "confirmed-email";
							if (Input::get("package-rico") == 195000) {
								$user->max_account = 3;
								$user->active_auto_manage = 30 * 86400;
							}
							if (Input::get("package-rico") == 395000) {
								$user->max_account = 3;
								$user->active_auto_manage = 90 * 86400;
							}
							if (Input::get("package-rico") == 449000) {
								$user->max_account = 6;
								$user->active_auto_manage = 90 * 86400;
							}
							if (Input::get("package-rico") == 695000) {
								$user->max_account = 3;
								$user->active_auto_manage = 180 * 86400;
							}
							if (Input::get("package-rico") == 799000) {
								$user->max_account = 6;
								$user->active_auto_manage = 180 * 86400;
							}
							if (Input::get("package-rico") == 1285000) {
								$user->max_account = 3;
								$user->active_auto_manage = 360 * 86400;
							}
							$user->link_affiliate = "";
						} else {
							if (Input::get("package-rico") == 195000) {
								if ($user->max_account<3) {
									$user->max_account = 3;
								}
								$user->active_auto_manage += 30 * 86400;
							}
							if (Input::get("package-rico") == 395000) {
								if ($user->max_account<3) {
									$user->max_account = 3;
								}
								$user->active_auto_manage += 90 * 86400;
							}
							if (Input::get("package-rico") == 449000) {
								if ($user->max_account<6) {
									$user->max_account = 6;
								}
								$user->active_auto_manage += 90 * 86400;
							}
							if (Input::get("package-rico") == 695000) {
								if ($user->max_account<3) {
									$user->max_account = 3;
								}
								$user->active_auto_manage += 180 * 86400;
							}
							if (Input::get("package-rico") == 799000) {
								if ($user->max_account<6) {
									$user->max_account = 6;
								}
								$user->active_auto_manage += 180 * 86400;
							}
							if (Input::get("package-rico") == 1285000) {
								if ($user->max_account<3) {
									$user->max_account = 3;
								}
								$user->active_auto_manage += 360 * 86400;
							}
						}
						$user->is_member_rico = 1;
						$user->save();
						
						UserMeta::createMeta("add_rico",Input::get("jumlahHari") * 86400,$user->id);
			
						//create order dicelebgramme
						$dt = Carbon::now();
						$order = new Order;
						$str = 'OCLB'.$dt->format('ymdHi');
						$order_number = GeneralHelper::autoGenerateID($order, 'no_order', $str, 3, '0');
						$order->no_order = $order_number;
					
						if (Input::get("package-rico") == 195000) {
							$order->package_manage_id = 9995;
							$order->total = 195000;
						}
						if (Input::get("package-rico") == 395000) {
							$order->package_manage_id = 9991;
							$order->total = 395000;
						}
						if (Input::get("package-rico") == 449000) {
							$order->package_manage_id = 9992;
							$order->total = 449000;
						}
						if (Input::get("package-rico") == 695000) {
							$order->package_manage_id = 9993;
							$order->total = 695000;
						}
						if (Input::get("package-rico") == 799000) {
							$order->package_manage_id = 9994;
							$order->total = 799000;
						}
						if (Input::get("package-rico") == 1285000) {
							$order->package_manage_id = 9996;
							$order->total = 1285000;
						}
						$order->image = "no image, from admin";
						$order->order_type = "rico-from-admin";
						$order->save();
						$order->checked = 1;
						$order->order_status = "success";
						$invoice = Invoice::where("order_id","=",$order->id)->first();
						if (is_null($invoice)){
							$invoice = new Invoice;
							$invoice->order_id = $order->id;

							$str = 'ICLB'.$dt->format('ymdHi');
							$invoice_number = GeneralHelper::autoGenerateID($invoice, 'no_invoice', $str, 3, '0');
							$invoice->no_invoice = $invoice_number;
						} 
						$invoice->total = $order->total;
						$invoice->save();
						
						$order->user_id = $user->id;
						$order->save();
									
									
						//create user dicelebpost
						$password_celebpost="";
						$user_celebpost = UserCelebpost::where('email', '=', $user->email)->first();
						if ( is_null($user_celebpost) ) {
							$user_celebpost = new UserCelebpost;
							$user_celebpost->username = $user->email;
							$user_celebpost->name = $row->name;
							$user_celebpost->email = $user->email;
							$pas = $user->email.$row->name;
							$gh = substr($pas, 0,6);
							$chrnd =substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
							$password_celebpost = str_replace(' ','', $gh.$chrnd);
							
							$user_celebpost->password = Hash::make($password_celebpost);
							$user_celebpost->is_confirmed = 1;
							$user_celebpost->is_admin = 0;
							$user_celebpost->is_started = 0;
							$user_celebpost->active_time = $user->active_auto_manage;
							$user_celebpost->remember_token = "";
							$user_celebpost->timezone = "Asia/Jakarta";
							$user_celebpost->verificationcode = "";
							$user_celebpost->last_seen = 0;
						}
						else {
							$user_celebpost->active_time += $user->active_auto_manage;
						}
						$user_celebpost->max_account = $user->max_account;
						$user_celebpost->is_member_rico = 1;
						$user_celebpost->save();
						
						$arr_user[] = [
								'user' => $user,
								'password' => $string,
								'user_celebpost' => $user_celebpost,
								'password_celebpost' => $password_celebpost,
								'harga' => $order->total,
						];

					}
				}
			}
			
			$emaildata = [
					'arr_user' => $arr_user,
			];
			Mail::queue('emails.add-rico', $emaildata, function ($message) {
				$message->from('no-reply@activfans.com', 'activfans');
				// $message->to("support@amelia.id");
				$message->to("celebgramme.dev@gmail.com");
				// $message->bcc("celebgramme.dev@gmail.com");
				// $message->subject('[Celebgramme] Welcome to Celebgramme / Celebpost (Info username & password)');
				$message->subject('[activfans] Data username password celebgramme & celebpost');
			});

			Excel::create(date("F j, Y, g:i a")." Data User Celebgramme Celebpost", function($excel) use ($arr_user) {
				$excel->sheet('keywords', function($sheet)use ($arr_user)  {
					$sheet->appendRow(array(
						"Email", "Celebgramme password", "Celebpost password", "Harga"
					));
					foreach ($arr_user as $data_user) { 
						$password_celebgramme = "*";
						if ($data_user['password']<>"") {
							$password_celebgramme = $data_user['password'];
						}
						$password_celebpost = "*";
						if ($data_user['password']<>"") {
							$password_celebpost = $data_user['password_celebpost'];
						}
						$sheet->appendRow(array(
							$data_user['user']->email, $password_celebgramme,$password_celebpost,$data_user['harga']
						));
					}
					$sheet->appendRow(array(
						"" 
					));
					$sheet->appendRow(array(
						"*user dengan email ini sudah punya login celebgramme" 
					));
				});
			})->store('csv');
			
		
    return $arr;
	}
	
  public function generate_member_rico()
  {
		$users = User::where("is_member_rico",1)
						->get();
		foreach ($users as $user) {
		}
						
		/*Excel::create(date("F j, Y, g:i a")." Data User Celebgramme Celebpost", function($excel) use ($users) {
			$excel->sheet('keywords', function($sheet)use ($users)  {
				$sheet->appendRow(array(
					"email", "password"
				));
				foreach ($users as $user) { 
					$sheet->appendRow(array(
						// $user->email, "Celebgramme pass :", $password_celebgramme,"","Celebpost pass:", $password_celebpost
						$user->email, $user->getAuthPassword(),
					));
				}
			});
		})->download('csv');*/
	}
	
  public function bonus_member()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add member berhasil dilakukan";


			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-list-bonus-member'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				//if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ( ($row->name=="") && ($row->email=="") )  {
							continue;
						}
						

						$data = array (
							"email" => $row->email,
						);
						$validator = Validator::make($data, [
							'email' => 'required|email|max:255',
						]);
						if ($validator->fails()){
							// $arr["type"] = "error";
							// $arr["message"] = "Email sudah terdaftar atau tidak valid";
							// return $arr;
							continue;
						}


						$user = User::where("email","=",$row->email)->first();
						$string = '';
						if (is_null($user)) {
							//password
							$karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
							for ($i = 0; $i < 8 ; $i++) {
								$pos = rand(0, strlen($karakter)-1);
								$string .= $karakter{$pos};
							}
							
							$user = new User;
							$user->password = $string;
							$user->email = $row->email;
							$user->fullname = $row->name;
							$user->type = "confirmed-email";
							$user->max_account = 3;
							$user->link_affiliate = "";
							$user->active_auto_manage = Input::get("jumlahHari") * 86400;

              $status = 'new';
						} else {
							$user->active_auto_manage += Input::get("jumlahHari") * 86400;
              $status = 'add';
						}

						$user->save();
						
            $jmlhari = Input::get("jumlahHari") * 86400;
            $adminlog = new AdminLog;
            $adminlog->user_id = Auth::user()->id;
            $adminlog->description = 'Add member excel, '.$user->email.', '.$jmlhari.' hari ('.$status.')';
            $adminlog->save();

						UserMeta::createMeta("bonus_waktu",Input::get("jumlahHari") * 86400,$user->id);

						$emaildata = [
								'user' => $user,
								'password' => $string,
								'jumlah_hari' => Input::get("jumlahHari"),
						];
						Mail::queue('emails.bonus', $emaildata, function ($message) use ($user) {
							$message->from('no-reply@activfans.com', 'activfans');
							$message->to($user->email);
							$message->subject('[activfans] Bonus activfans.com');
						});
					}
				//}
			}

		
    return $arr;
	}
	
  public function add_member()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add member berhasil dilakukan";

		if (Request::input("select_input") == "manual") {
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

			$affiliate = Affiliate::find(Request::input("select-affiliate"));
			$affiliate->jumlah_user_daftar += 1;
			$affiliate->save();
			$user->active_auto_manage = $affiliate->jumlah_hari_free_trial * 86400;
			$user->max_account = 3;
			$user->link_affiliate = $affiliate->link;
			$user->save();
			
			UserMeta::createMeta("nama affiliate",$affiliate->nama,$user->id);
			UserMeta::createMeta("start_waktu",$affiliate->jumlah_hari_free_trial * 86400,$user->id);

			$emaildata = [
					'user' => $user,
					'password' => $string,
			];
			Mail::queue('emails.create-user-free-trial', $emaildata, function ($message) use ($user) {
				$message->from('no-reply@activfans.com', 'activfans');
				$message->to($user->email);
				$message->subject('[activfans] Welcome to activfans.com');
			});
		}
		
		if (Request::input("select_input") == "excel") {
			
			
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = 'file-list-new-member'.date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ( ($row->name=="") && ($row->email=="") )  {
							continue;
						}
						

						$data = array (
							"email" => $row->email,
						);
						$validator = Validator::make($data, [
							'email' => 'required|email|max:255|unique:users',
						]);
						if ($validator->fails()){
							// $arr["type"] = "error";
							// $arr["message"] = "Email sudah terdaftar atau tidak valid";
							// return $arr;
							continue;
						}

						$karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
						$string = '';
						for ($i = 0; $i < 8 ; $i++) {
							$pos = rand(0, strlen($karakter)-1);
							$string .= $karakter{$pos};
						}

						$user = new User;
						$user->email = $row->email;
						$user->password = $string;
						$user->fullname = $row->name;
						$user->type = "confirmed-email";
						$user->save();

						$affiliate = Affiliate::find(Request::input("select-affiliate"));
						$affiliate->jumlah_user_daftar += 1;
						$affiliate->save();
						$user->active_auto_manage = $affiliate->jumlah_hari_free_trial * 86400;
						$user->max_account = 3;
						$user->link_affiliate = $affiliate->link;
						$user->save();
						
						UserMeta::createMeta("nama affiliate",$affiliate->nama,$user->id);
						UserMeta::createMeta("start_waktu",$affiliate->jumlah_hari_free_trial * 86400,$user->id);

						$emaildata = [
								'user' => $user,
								'password' => $string,
						];
						Mail::queue('emails.create-user-free-trial', $emaildata, function ($message) use ($user) {
							$message->from('no-reply@activfans.com', 'activfans');
							$message->to($user->email);
							$message->subject('[activfans] Welcome to activfans.com');
						});


						
						
						
						
					}
				}
			}
			
		}


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
		$user_log->description = "Edit Member. email : ".Request::input("emailedit").", fullname : ".Request::input("fullnameedit").", time : ".Request::input("member-days") ."days";
		$user_log->created = $dt->toDateTimeString();
		$user_log->save();

    $adminlog = new AdminLog;
    $adminlog->user_id = Auth::user()->id;
    $adminlog->description = "Edit Member. email : ".Request::input("emailedit").", fullname : ".Request::input("fullnameedit").", time : ".Request::input("member-days") ."days";
    $adminlog->save();
		
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

  public function edit_member_max_account()
	{
    $arr["type"] = "success";
    $arr["message"] = "Proses edit member berhasil dilakukan";

		$user = User::find(Request::input("user-id"));
		$user->max_account = Request::input("max-account-user");
		$user->save();

    $adminlog = new AdminLog;
    $adminlog->user_id = Auth::user()->id;
    $adminlog->description = 'Tambah Max Account, '.$user->email.', '.Request::input("max-account-user").' account';
    $adminlog->save();

    return $arr;
	}

  public function delete_member()
  {
		$user = User::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }

  public function member_order_package()
  {
    //hitung total
		/*$total = 0;
		// $package = Package::find(Input::get("package-daily-likes"));
		// if (!is_null($package)) {
			// $total += $package->price;
		// }
		$package = Package::find(Input::get("package-auto-manage"));
		if (!is_null($package)) {
			$total += $package->price;
		}
		$dt = Carbon::now();
		$coupon = Coupon::where("coupon_code","=",Input::get("coupon-code"))
					->where("valid_until",">=",$dt->toDateTimeString())->first();
		if (!is_null($coupon)) {
			$total -= $coupon->coupon_value;
			if ($total<0) { $total =0; }
		}
		
		$data = array (
			"order_type" => "transfer_bank",
			"order_status" => "pending",
			"user_id" => Request::input("user-id"),
			"order_total" => $total,
			"package_manage_id" => Input::get("package-auto-manage"),
			"coupon_code" => Input::get("coupon-code"),
			"logs" => "EXISTING MEMBER",
		);
		
		$order = Order::createOrder($data,true);
		
    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");*/

    $total = 0;
    $package = Package::find(Input::get("package-auto-manage"));
    if (!is_null($package)) {
      $total += $package->price;
    }

    $data = array (
      "user_id" => Request::input("user-id"),
      "order_total" => $total,
      "package_manage_id" => Input::get("package-auto-manage"),
    );

    $order = Order::createNewOrder($data);

    $adminlog = new AdminLog;
    $adminlog->user_id = Auth::user()->id;
    $adminlog->description = 'Create Order Manual, '.$order;
    $adminlog->save();

    $arr['type'] = 'success';
    $arr['message'] = 'Add Order berhasil';

    return $arr;    
  }

  public function add_order_excel(){
    if(Input::hasFile('fileExcel')){
      $uploadedFile = Input::file('fileExcel');
      $path = $uploadedFile->getRealPath();

      $data = Excel::load($path)->get();
      if(!empty($data) && $data->count()){

        foreach ($data as $key => $value) {
          if($value->email!='' || $value->paket!='') {
						
						$dataValidator = array (
							"email" => $value->email,
						);
						$validator = Validator::make($dataValidator, [
							'email' => 'required|email|max:255',
						]);
						if ($validator->fails()){
							continue;
						}

						//ita code
						$total = 0;
						$package = Package::find($value->paket);
						if (!is_null($package)) {
							$total += $package->price;
						}

						$user = User::where("email","=",$value->email)->first();
						$string = '';
						if (is_null($user)) {
							//password
							$karakter= 'abcdefghjklmnpqrstuvwxyz123456789';
							for ($i = 0; $i < 8 ; $i++) {
								$pos = rand(0, strlen($karakter)-1);
								$string .= $karakter{$pos};
							}
							
							$user = new User;
							$user->password = $string;
							$user->email = $value->email;
							$user->fullname = $value->email;
							$user->type = "confirmed-email";
							$user->max_account = 3;
							$user->link_affiliate = "";
							$user->active_auto_manage = $package->active_days * 86400;

              $status = 'new';
						} else {
							$user->active_auto_manage += $package->active_days * 86400;
              $status = 'add';
						}

						$user->save();

						//ita code
						$data = array (
							"user_id" => $user->id,
							"order_total" => $total,
							"package_manage_id" => $value->paket,
						);

						$order = Order::createNewOrder($data);

						$adminlog = new AdminLog;
						$adminlog->user_id = Auth::user()->id;
						$adminlog->description = 'Create Order Excel, '.$order.' ('.$status.')';
						$adminlog->save();
						//ita code
          }
        }

        $arr['type'] = 'success';
        $arr['message'] = 'Add Order berhasil';

      }

    } else {
      $arr['type'] = 'error';
      $arr['message'] = 'Pilih file terlebih dahulu';
    }

    return $arr;    
  }

  public function sample_add_order(){
    $packages = Package::where("package_group","=","auto-manage")
                ->orderBy('price', 'asc')->get();

    Excel::create('sample', function($excel) use ($packages) {
        $excel->sheet('list', function($sheet) use ($packages) {
          $sheet->cell('A1', function($cell) {
            $cell->setValue('email');   
          });
          $sheet->cell('B1', function($cell) {
            $cell->setValue('paket');   
          });
          $sheet->cell('G1', function($cell) {
            $cell->setValue('Ket');   
          });

          if ($packages->count()) {
            $i=2;
            foreach ($packages as $package) {
              $sheet->cell('G'.$i, $package->id); 

              $paket = 'Paket '.$package->package_name.' - Rp '.$package->price;
              $sheet->cell('H'.$i, $paket);

              $i++;
            }

            $sheet->cell('A2', 'aa@gmail.com'); 
            $sheet->cell('A3', 'bb@gmail.com'); 
            $sheet->cell('A4', 'cc@gmail.com'); 
          
            $sheet->cell('B2', $packages[0]->id); 
            $sheet->cell('B3', $packages[1]->id); 
            $sheet->cell('B4', $packages[0]->id); 
          }
        });
      })->download('xlsx');
  }

  /**
   * Show Admin all page.
   *
   * @return Response
   */
  public function admin()
  {
    $email = Auth::user()->email;
    if($email=='admin@admin.com' || $email=='celebgramme.dev@gmail.com' || $email=='puspita.celebgramme@gmail.com' || $email=='it.axiapro@gmail.com'){

      $user = Auth::user();
      $orders = Order::where("affiliate","=","1")->
               where("user_id","=","0");
      return View::make('admin.admin-all.index')->with(
                    array(
                      'user'=>$user,
                      'orders'=>$orders,
                    ));
    } else {
      return response('Unauthorized.', 401);
    }
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
      $message->from('no-reply@activfans.com', 'activfans');
      $message->to($user->email);
      $message->subject('[activfans] Welcome to activfans.com');
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
	
  public function home_page()
  {
    $user = Auth::user();
		$post = Post::where("type","=","home_page")->first();
		if (is_null($post)) {
			$post = new Post;
			$post->type="home_page";
			$post->save();
		}
		$content = $post->description;
    return View::make('admin.member-all.home')->with(
                  array(
                    'user'=>$user,
                    'content'=>$content,
                  ));
	}

  public function save_home_page()
  {
		$arr["type"] = "success";
		$arr["message"] = "Saved";

		$post = Post::where("type","=","home_page")->first();
		$post->description=Request::input("content");
		$post->type="home_page";
		$post->save();

		return $arr;
	}

  public function footer_ads()
  {
    $user = Auth::user();
		$post = Post::where("type","=","footer_ads")->first();
		if (is_null($post)) {
			$post = new Post;
			$post->type="footer_ads";
			$post->save();
		}
		$content = $post->description;
    return View::make('admin.member-all.footer')->with(
                  array(
                    'user'=>$user,
                    'content'=>$content,
                  ));
	}

  public function save_footer_ads()
  {
		$arr["type"] = "success";
		$arr["message"] = "Saved";

		$post = Post::where("type","=","footer_ads")->first();
		$post->description=Request::input("content");
		$post->type="footer_ads";
		$post->save();

		return $arr;
	}

  public function ads_page()
  {
    $user = Auth::user();
		$post = Post::where("type","=","ads")->first();
		if (is_null($post)) {
			$post = new Post;
			$post->type="ads";
			$post->save();
		}
		$content = $post->description;
    return View::make('admin.member-all.ads')->with(
                  array(
                    'user'=>$user,
                    'content'=>$content,
                  ));
	}

  public function save_ads_page()
  {
		$arr["type"] = "success";
		$arr["message"] = "Saved";

		$post = Post::where("type","=","ads")->first();
		$post->description=Request::input("content");
		$post->type="ads";
		$post->save();

		return $arr;
	}
	
	public function get_time_logs() {
		$logs = "";
		
		$timeLogs = TimeLog::where("user_id","=",Request::Input("id"))->orderBy('id', 'desc')->get();
		foreach($timeLogs as $timeLog){
			$t = $timeLog->time;
			$days = floor($t / (60*60*24));
			$hours = floor(($t / (60*60)) % 24);
			$minutes = floor(($t / (60)) % 60);
			$seconds = floor($t  % 60);
			$logs .= "<tr><td>".$timeLog->created."</td><td>".$days."D ".$hours."H ".$minutes."M ".$seconds."S"."</td></tr>";
			
		}
		
		$arr["logs"] = $logs;
		$arr["type"] = "success";
		return $arr;
	}
	
  public function edit_email(){
    $arr["type"] = "success";
    $arr["message"] = "Proses edit email berhasil dilakukan";

    $data = array (
      "email" => Request::input('email'),
    );
    $validator = Validator::make($data, [
      'email' => 'required|email|max:255',
    ]);

    if ($validator->fails()){
      $arr["type"] = "error";
      $arr["message"] = "Format email salah";
    } else {
      $cekemail = User::where('email',Request::input("email"))->first();
      if(is_null($cekemail)){
        $user = User::find(Request::input("id-edit"));
        
        $adminlog = new AdminLog;
        $adminlog->user_id = Auth::user()->id;
        $adminlog->description = 'Ubah email, '.$user->email.'->'.Request::input("email").', userID:'.$user->id;
        $adminlog->save();

        $user->email = Request::input("email");
        $user->save();
      } else {
        $arr["type"] = "error";
        $arr["message"] = "Email sudah terdaftar";
      }
    }
  
    return $arr;
  }

  public function show_log(){
    $adminlog = AdminLog::where('user_id',Request::input('id_log'))
                  ->whereDate('created_at','>=',Request::input('from-log'))
                  ->whereDate('created_at','<=',Request::input('to-log'))
                  ->where('description','like','%'.Request::input('description').'%')
                  ->paginate(10);
    
    $arr['view'] = (string) view('admin.admin-all.content-log')
                      ->with('arr',$adminlog);
    $arr['pagination'] = (string) view('admin.admin-all.pagination-log')
                      ->with('arr',$adminlog);

    return $arr;
  }

  public function submit_refund(){
    $refund = new Refund;
    $refund->user_id = Request::input('id_refund');
    $refund->total = Request::input('total');
    $refund->save();

    $user = User::find(Request::input('id_refund'));

    $adminlog = new AdminLog;
    $adminlog->user_id = Auth::user()->id;
    $adminlog->description = 'Refund, '.$user->email.', total = Rp.'.number_format(Request::input("total"));
    $adminlog->save();

    $arr['type'] = 'success';
    $arr['message'] = 'Refund berhasil dilakukan';

    return $arr;
  }

  public function member_refund(){
    $user = Auth::user();
  
    return View::make('admin.member-refund.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }

  public function load_member_refund(){
    $admin = Auth::user();
    $refund = Refund::join('users','refund.user_id','=','users.id')
                ->select('refund.*','users.fullname','users.email')
                ->where(function($query) {
                  $query->where('email','like','%'.Request::input('keyword').'%')
                        ->orWhere('fullname','like','%'.Request::input('keyword').'%');
                  })
                ->orderBy('created_at','desc')
                ->paginate(15);

    $arr['view'] = (string) view('admin.member-refund.content')
                    ->with(array(
                      'admin'=>$admin,
                      'arr'=>$refund,
                      'page'=>Request::input('page'),
                    ));
    $arr['pagination'] = (string) view('admin.member-refund.pagination')
                        ->with('arr',$refund);

    return $arr;
  }

  public function data_user(){
    $user = Auth::user();

    return view('admin.data-user.index')->with('user',$user);
  }

  public function load_data_user(){
    $users = User::join(env('DB_CELEBPOST_DATABASE').'.users as userclbp','users.email','=','userclbp.email')
              ->select('users.id','users.created_at','users.fullname','users.email','users.active_auto_manage','userclbp.active_time')
              ->where("users.type","<>","admin")
              ->where("users.email",'like',"%".Request::input('keyword')."%");

    if(Request::input('status_user')=='Time Out Activfans'){
        $users = $users->where('active_auto_manage',0);

    } else if(Request::input('status_user')=='Time Out Activpost') {
        $users = $users->where('active_time',0);

    } else if(Request::input('status_user')=='Not Active Activfans'){
        $users = $users->where('active_auto_manage','!=',0)
                  ->whereRaw('MOD(active_auto_manage, 2592000) = 0');

    } else if(Request::input('status_user')=='Not Active Activpost'){
        $users = $users->where('active_time','!=',0)
                  ->whereRaw('MOD(active_time, 2592000) = 0');

    } else if(Request::input('status_user')=='Active'){
        $users = $users->where('active_auto_manage','!=',0)
                  ->where('active_time','!=',0)
                  ->where(function($query) {
                      $query->whereRaw('MOD(active_auto_manage, 2592000) != 0')
                        ->orwhereRaw('MOD(active_time, 2592000) != 0'); 
                  });
    }

    if(Request::input('sort')==1){
      $users = $users->orderBy('created_at','desc');
    } else {
      $users = $users->orderBy('active_auto_manage','desc');
    }

    $users = $users->paginate(15);

    $arr['view'] = (string) view('admin.data-user.content')
                    ->with('arr',$users)
                    ->with('page',Request::input('page'));
    $arr['pagination'] = (string) view('admin.data-user.pagination')
                          ->with('arr',$users);

    return $arr;
  }

  public function renewal_rate(){
    $user = Auth::user();

    return view('admin.renewal-rate.index')->with('user',$user);
  }

  public function load_renewal(){
    $users = User::join('orders','users.id','=','orders.user_id')
              ->select('users.id','orders.user_id','users.created_at','users.fullname','users.email',DB::raw('count(*) as jml'))
              ->where(function($query) {
                  $query->where('users.email','like','%'.Request::input('keyword').'%')
                        ->orWhere('users.fullname','like','%'.Request::input('keyword').'%');
                })
              ->where('users.is_member_rico',1)
              ->groupBy('orders.user_id')
              ->havingRaw('jml > 1')->get();

    /*$active = User::join(env('DB_CELEBPOST_DATABASE').'.users as userclb','users.email','=','userclb.email')
                ->where('users.is_member_rico',1)
                ->where('users.active_auto_manage','!=',0)
                ->where('userclb.active_time','!=',0)
                ->whereRaw('MOD(users.active_auto_manage, 2592000) != 0')
                ->orwhereRaw('MOD(userclb.active_time, 2592000) != 0')
                ->get(); */

      $active = ViewUserAffiliate::select('id','created_at','name','email','owner_id','active_auto_manage','active_time')
                //->where('owner_id',Auth::user()->is_admin)
                ->where('is_admin',0)
                ->where('active_auto_manage','!=',0)
                ->where('active_time','!=',0)
                ->whereRaw('MOD(active_auto_manage, 2592000) != 0')
                //->orwhereRaw('MOD(active_time, 2592000) != 0')
                ->get();  

      $rate = round($users->count() / $active->count() * 100,2);

      $arr['view'] = (string) view('admin.renewal-rate.content')
                      ->with('arr',$users)
                      ->with('page',Request::input('page'));
      $arr['rate'] = $rate;
      $arr['total'] = $users->count();
      $arr['active'] = $active->count();

      return $arr;
  }

  public function load_reflink(){
    $refers = Referral::join('users','users.id','=','referrals.user_id_taker')
                ->where('referrals.user_id_giver',Request::input('id'))
                ->get();

    $arr['view'] = (string) view('admin.member-all.content-reflink')
                      ->with('refers',$refers);
    return $arr;
  }

}
