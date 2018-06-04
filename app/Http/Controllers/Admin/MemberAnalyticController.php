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
use Celebgramme\Models\Coupon;
use Celebgramme\Models\TimeLog;
use Celebgramme\Models\Affiliate;

use View,Auth,Request,DB,Carbon,Mail,Validator, Input, Excel, Config;

class MemberAnalyticController extends Controller {


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
   * Show Member all page.
   *
   * @return Response
   */
  public function index()
  {
    $user = Auth::user();
    $arr = User::where("type","<>","admin")
             ->select(DB::raw("sum(active_auto_manage) as total_time_manage"))
             ->orderBy('id', 'desc')
             ->get();
		$packages = Package::where("package_group","=","auto-manage")
								->orderBy('price', 'asc')->get();
	  $affiliates = Affiliate::all();
    return View::make('admin.member-analytic.index')->with(
                  array(
                    'user'=>$user,
                    'affiliates'=>$affiliates,
                    'packages'=>$packages,
                    'total_auto_manage'=>$arr[0]->total_time_manage,
                  ));
  }

  public function load_member()
  {
		$admin = Auth::user();
		//new register
		if (Request::input("searchBy") == "1") {
			$arr = User::where("type","<>","admin")
					 ->where('created_at','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('created_at', 'desc')
					 ->paginate(15);
		}
		//renew register
		else if (Request::input("searchBy") == "2") {
			$arr = User::join("orders","users.id","=","orders.user_id")
					 ->where("type","<>","admin")
					 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('orders.created_at', 'desc')
					 ->paginate(15);
		}
		//Not Extend user
		else if (Request::input("searchBy") == "3") {
			$arr = User::join("settings","settings.last_user","=","users.id")
					 ->where("type","<>","admin")
					 ->where('active_auto_manage',0)
					 ->where('running_time','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('running_time','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('created_at', 'desc')
					 ->paginate(15);
		}
    return view('admin.member-analytic.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_member()
  {
		//new register
		if (Request::input("searchBy") == "1") {
			$arr = User::where("type","<>","admin")
					 ->where('created_at','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('created_at', 'desc')
					 ->paginate(15);
		}
		//renew register
		else if (Request::input("searchBy") == "2") {
			$arr = User::join("orders","users.id","=","orders.user_id")
					 ->where("type","<>","admin")
					 ->where('orders.created_at','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('orders.created_at','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('orders.created_at', 'desc')
					 ->paginate(15);
		}
		//Not Extend user
		else if (Request::input("searchBy") == "3") {
			$arr = User::join("settings","settings.last_user","=","users.id")
					 ->where("type","<>","admin")
					 ->where('active_auto_manage',0)
					 ->where('running_time','>=',date("Y-m-d", intval(Request::input('from'))))
					 ->where('running_time','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
					 ->orderBy('created_at', 'desc')
					 ->paginate(15);
		}

    return view('admin.member-analytic.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

	
}
