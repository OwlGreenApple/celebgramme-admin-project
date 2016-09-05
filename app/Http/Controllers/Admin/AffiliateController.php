<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Affiliate;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator;

class AffiliateController extends Controller {


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
	 * Show proxy page.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();

		return View::make('admin.affiliate.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_affiliate()
  {
    $user = Auth::user();
		
		if (Request::input('search')=="") {
			$data = Affiliate::paginate(15);
		} else {
			$data = Affiliate::
							where("nama","like","%".Request::input('search')."%")
							->orWhere("link","like","%".Request::input('search')."%")
							->paginate(15);
		}
    return view('admin.affiliate.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_affiliate()
  {
		if (Request::input('search')=="") {
			$data = Affiliate::paginate(15);
		} else {
			$data = Affiliate::
							where("nama","like","%".Request::input('search')."%")
							->orWhere("link","like","%".Request::input('search')."%")
							->paginate(15);
		}
    return view('admin.affiliate.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_affiliate()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add / edit affiliate berhasil dilakukan";
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');
		
		if ( Request::input("id_affiliate")=="new" ) {
			$affiliate = Affiliate::
								where("nama","=",Request::input("nama"))
								->first();
			if (!is_null($affiliate)) {
				$arr["type"] = "error";
				$arr["message"] = "Nama affiliate sudah terdaftar sebelumnya";
				return $arr;
			}
			$affiliate = new Affiliate;
		} else {
			$affiliate = Affiliate::find(Request::input("id_affiliate"));
		}
		$affiliate->nama = Request::input("nama");
		$affiliate->link = Request::input("link");
		$affiliate->jumlah_hari_free_trial = Request::input("jumlah_hari_affiliate");
		$affiliate->created = $dt->toDateTimeString();
		$affiliate->save();

		return $arr;
	}

	public function delete_affiliate()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete affiliate berhasil dilakukan";

		$check_affiliate = Affiliate::find(Request::input("id"));
		if (!is_null($check_affiliate)) {
			$check_affiliate->delete();
		}

		return $arr;
	}
  
}
