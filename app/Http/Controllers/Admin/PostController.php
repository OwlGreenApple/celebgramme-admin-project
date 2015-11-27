<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;

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
    return "success";
  }
    
}
