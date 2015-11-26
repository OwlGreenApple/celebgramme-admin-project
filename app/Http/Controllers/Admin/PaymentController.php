<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Products;

use View,Auth,Request,DB,Carbon,Excel;

class PaymentController extends Controller {


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
	 * Show 1stpremi page.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();
		return View::make('admin.confirm.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_payment()
  {
    if (Request::input('search')=="") {
      $tb_konfirmasi_premi = Tb_konfirmasi_premi::where('created','>=',date("Y-m-d", intval(Request::input('from'))))
                             ->where('created','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                             ->orderBy('created', 'desc')->paginate(15);
    } else {
      $tb_konfirmasi_premi = Tb_konfirmasi_premi::where('created','>=',date("Y-m-d", intval(Request::input('from'))))
                              ->where('created','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                              ->where('username','=',Request::input('search'))
                              ->orWhere('nama','like','%'.Request::input('search').'%')
                              ->orWhere('nopolis','like','%'.Request::input('search').'%')
                              ->orderBy('created', 'desc')->paginate(15);
    }

    $user = Auth::user();
    return view('admin.confirm.content')->with(
                array(
                  'user'=>$user,
                  'tb_konfirmasi_premi'=>$tb_konfirmasi_premi,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_payment()
  {
    if (Request::input('search')=="") {
      $tb_konfirmasi_premi = Tb_konfirmasi_premi::where('created','>=',date("Y-m-d", intval(Request::input('from'))))
                             ->where('created','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                             ->orderBy('created', 'desc')->paginate(15);
    } else {
      $tb_konfirmasi_premi = Tb_konfirmasi_premi::where('created','>=',date("Y-m-d", intval(Request::input('from'))))
                              ->where('created','<=',date("Y-m-d", intval(Request::input('to'))).' 23:59:59')
                              ->where('username','=',Request::input('search'))
                              ->orWhere('nama','like','%'.Request::input('search').'%')
                              ->orWhere('nopolis','like','%'.Request::input('search').'%')
                              ->orderBy('created', 'desc')->paginate(15);
    }

    return view('admin.confirm.pagination')->with(
                array(
                  'tb_konfirmasi_premi'=>$tb_konfirmasi_premi,
                ));
  }

	public function update_payment($konfirmasiId)
  {
    // $req = $request->except('_method','_token','ex_nopolis','ex_username');
    // Tb_konfirmasi_premi::find($konfirmasiId)->update(array('status'=>"1",));
    $tb_konfirmasi_premi = Tb_konfirmasi_premi::find($konfirmasiId);
    $tb_konfirmasi_premi->status = "1";
    $tb_konfirmasi_premi->save();
    
    if ($tb_konfirmasi_premi->jumlah==100000) {
      $member = Member::where("username","=",$tb_konfirmasi_premi->username)->first();
      $member->warning_renewal = false;
      $member->save();
    }
    
    Admin_logs::log_activity('update ( nopolis : '.$tb_konfirmasi_premi->nopolis.')',array("status"=>"1",),'edit konfirmasi premi (status)',0);
    return "success";
  }

	public function edit()
  {
    $tb_konfirmasi_premi = Tb_konfirmasi_premi::find(Request::input("editId"));
    $config_packages = Config_packages::where('showed','=',true)->get();
    return view('admin.confirm._editConfirmModal')->with(
                array(
                  'tb_konfirmasi_premi'=>$tb_konfirmasi_premi,
                  'config_packages'=>$config_packages,
                ));
  }

	public function update_confirm()
  {
    $config_package = Config_packages::find(Request::input("jenisPremi"));

    $tb_konfirmasi_premi = Tb_konfirmasi_premi::find(Request::input("idConfirm"));

    $arrayOld = array (
      "nohp" => $tb_konfirmasi_premi->nohp, 
      "email" => $tb_konfirmasi_premi->email, 
      "package_id" => $tb_konfirmasi_premi->config_package_id, 
      "topup" => $tb_konfirmasi_premi->topup, 
    );
    $arrayNew = array (
      "nohp" => Request::input("noHP"), 
      "email" => Request::input("email"), 
      "package_id" => Request::input("jenisPremi"), 
      "topup" => Request::input("topup"), 
    );
    $diff = array_diff_assoc($arrayNew,$arrayOld);
    Admin_logs::log_activity('update ( nopolis : '.$tb_konfirmasi_premi->nopolis.')',$diff,'edit konfirmasi premi (data)',0);
    
    $tb_konfirmasi_premi->email = Request::input("email");
    $tb_konfirmasi_premi->nohp = Request::input("noHP");
    $tb_konfirmasi_premi->config_package_id = Request::input("jenisPremi");
    $tb_konfirmasi_premi->jenis_premi = $config_package->value;
    $tb_konfirmasi_premi->topup = Request::input("topup");
    $tb_konfirmasi_premi->jumlah = $config_package->value + Request::input("topup");
    $tb_konfirmasi_premi->save();
    
    $arr['type']="success";
    $arr['message']="Proses Edit berhasil dilakukan";
    $arr['id'] = Request::input("idConfirm");
    $arr['jumlah'] = number_format($config_package->value,0,'','.');
    $arr['topup'] = number_format(Request::input("topup"),0,'','.');
    $arr['total'] = number_format($config_package->value + Request::input("topup"),0,'','.');
    return $arr;
  }
  
}
