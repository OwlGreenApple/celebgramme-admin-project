<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Meta;
use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\SettingMeta; 
use Celebgramme\Models\SettingHelper; 
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\TemplateEmail;
use Celebgramme\Models\LinkProxySetting;
use Celebgramme\Models\Proxies;
use Celebgramme\Models\Category;

use Celebgramme\Helpers\GlobalHelper;

use View,Auth,Request,DB,Carbon,Excel,Mail,Input;

class CategoriesController extends Controller {


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
	 * Show Setting Page.
	 *
	 * @return Response
	 */
	public function index($search="")
	{
    $user = Auth::user();
		
		return View::make('admin.categories.index')->with(
                  array(
                    'search'=>$search,
                    'user'=>$user,
                  ));
	}

  public function load()
  {
		$admin = Auth::user();
		if (Request::input("keyword")=="") {
			$arr = Category::
					 orderBy('id', 'asc')
					 ->paginate(15);
		}
		else {
			$arr = Category::where("name","like","%".Request::input("keyword")."%")
					 ->orderBy('id', 'asc')
					 ->paginate(15);
		}
    return view('admin.categories.content')->with(
                array(
                  'admin'=>$admin,
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination()
  {
		if (Request::input("keyword")=="") {
			$arr = Category::
					 orderBy('id', 'asc')
					 ->paginate(15);
		}
		else {
			$arr = Category::where("name","like","%".Request::input("keyword")."%")
					 ->orderBy('id', 'asc')
					 ->paginate(15);
		}
		
    return view('admin.categories.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function update()
  {
		$dt = Carbon::now()->setTimezone('Asia/Jakarta');
		if (Request::input("category-id")=="new") {
			$category =  new Category;
		} else {
			$category =  Category::find(Request::input("category-id"));
		}
		$category->categories = Request::input("categories");
		$category->name = Request::input("name");
		$category->hashtags = Request::input("hashtags");
		$category->username = Request::input("username");
		$category->created = $dt->toDateTimeString();
		$category->save();
		
		$arr["type"] = "success";
		$arr["message"] = "data berhasil disimpan";
		return $arr;
	}

	public function delete()
  {
		$category =  Category::find(Request::input("id"))->delete();
		$arr["type"] = "success";
		$arr["message"] = "data berhasil dihapus";
		return $arr;
	}
	
}
