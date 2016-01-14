<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\Invoice;
use Celebgramme\Models\Order;
use Celebgramme\Models\User;
use Celebgramme\Models\Package;
use Celebgramme\Models\PackageUser;
use Celebgramme\Models\Coupon;

use View,Auth,Request,DB,Carbon,Excel, Mail;

class PackageController extends Controller {


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
* Order
*
*/
  /**
   * Show Order page.
   *
   * @return Response
   */
  public function package_auto_manage()
  {
    $user = Auth::user();
		

    return View::make('admin.package-auto-manage.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }

  public function load_package_auto_manage()
  {
    $arr = Package::where("package_group","=","auto-manage")->paginate(15);

    return view('admin.package-auto-manage.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
  public function pagination_package_auto_manage()
  {
    $arr = Package::where("package_group","=","auto-manage")->paginate(15);
    
    return view('admin.package-auto-manage.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }

  public function add_package()
  {
    if (Request::input("id-package")=="new") {
      $package = new Package;
    } else {
      $package = Package::find(Request::input("id-package"));
    }
		$package->package_name = Request::input("packagename");
		$package->price = Request::input("price");
		$package->active_days = Request::input("active-days");
		$affiliate_check = Request::input("affiliate-check");
		if (isset($affiliate_check)) { $package->affiliate = 1; } else { $package->affiliate = 0; }
		$package->package_group = "auto-manage";
		$package->save();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-package");
    return $arr;    
  }

  public function delete_package()
  {
		$package = Package::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    $arr['id'] = Request::input("id-coupon");
    return $arr;    
  }



  
}
