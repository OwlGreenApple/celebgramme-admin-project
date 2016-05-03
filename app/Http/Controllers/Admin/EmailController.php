<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\EmailUser;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator;

class EmailController extends Controller {


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
		return View::make('admin.email.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_email_users()
  {
    $user = Auth::user();
		$data = EmailUser::paginate(15);
    return view('admin.email.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_email_users()
  {
		$data = EmailUser::paginate(15);
    return view('admin.email.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add user email berhasil dilakukan";
		
		return $arr;
	}

	public function edit_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses edit user email berhasil dilakukan";
		
		return $arr;
	}

	public function delete_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete user email berhasil dilakukan";
		
		return $arr;
	}

	public function blast_email()
	{
    $user = Auth::user();
		return View::make('admin.email.blast-email')->with(
                  array(
                    'user'=>$user,
										'content'=>"",
                  ));
  }

	public function send_blast_email()
  {
		$emailusers = EmailUser::all();
		$subject = Request::input("subject");
		$content = Request::input("content");
		foreach($emailusers as $emailuser){
					$content = str_replace("/nama/", $emailuser->fullname, $content);
					$subject = str_replace("/nama/", $emailuser->fullname, $subject);
					$emaildata = [
							'content' => $content,
					];
					Mail::queue('emails.content', $emaildata, function ($message) use ($emailuser,$subject) {
						$message->from('no-reply@celebgramme.com', 'Celebgramme');
						$message->to($emailuser->email);
						$message->subject($subject);
					});
			
		}
		return "";
	}
}
