<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Models\Meta;
use Celebgramme\Models\User;
use Celebgramme\Models\RequestModel;
use Celebgramme\Models\Post;
use Celebgramme\Models\Setting;
use Celebgramme\Models\SettingMeta; 
use Celebgramme\Models\LinkUserSetting;
use Celebgramme\Models\TemplateEmail;

use View,Auth,Request,DB,Carbon,Excel,Mail;

class MetaController extends Controller {


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
	 * Show Follow liker list name Page.
	 *
	 * @return Response
	 */
	public function fl_name()
	{
    $user = Auth::user();
		return View::make('admin.fl-name-list.index')->with(
                  array(
                    'user'=>$user,
                  ));
	}

  public function load_fl_name()
  {
		$arr = Meta::where("meta_name","=","fl_name")
					 ->orderBy('id', 'asc')
					 ->paginate(15);
    
    return view('admin.fl-name-list.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_fl_name()
  {
		$arr = Meta::where("meta_name","=","fl_name")
					 ->orderBy('id', 'asc')
					 ->paginate(15);


    return view('admin.fl-name-list.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function add_fl()
  {
		if (Request::input("id_meta")=="new") {
			$meta = new Meta;
		} else {
			$meta = Meta::find(Request::input("id_meta"));
		}
		$meta->meta_name= "fl_name";
		$meta->meta_value= Request::input("data_value");
		$meta->save();
    
		$arr["type"] = "success";
    return $arr;
  }
	
	public function delete_fl()
  {
		$meta = Meta::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    return $arr;    
	}


	
	
	/**
	 * Show templates email Page.
	 *
	 * @return Response
	 */
	public function template_email()
	{
    $user = Auth::user();
		return View::make('admin.template-email-list.index')->with(
                  array(
                    'user'=>$user,
                  ));
	}

  public function load_template_email()
  {
		$arr = TemplateEmail::orderBy('id', 'asc')
					 ->paginate(15);
    
    return view('admin.template-email-list.content')->with(
                array(
                  'arr'=>$arr,
                  'page'=>Request::input('page'),
                ));
  }
  
	public function pagination_template_email()
  {
		$arr = TemplateEmail::orderBy('id', 'asc')
					 ->paginate(15);


    return view('admin.template-email-list.pagination')->with(
                array(
                  'arr'=>$arr,
                ));
  }
  
	public function add_template_email()
  {
		if (Request::input("id_template")=="new") {
			$template = new TemplateEmail;
		} else {
			$template = TemplateEmail::find(Request::input("id_template"));
		}
		$template->name= Request::input("name_template");
		$template->title= Request::input("title_template");
		$template->message= Request::input("message_template");
		$template->save();
    
		$arr["type"] = "success";
    return $arr;
  }
	
	public function delete_template_email()
  {
		$template = TemplateEmail::find(Request::input("id"))->delete();

    $arr['type'] = 'success';
    return $arr;    
	}

	
}
