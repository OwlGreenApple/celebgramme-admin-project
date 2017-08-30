<?php namespace Celebgramme\Http\Controllers\Admin;

use Celebgramme\Http\Requests;
use Celebgramme\Http\Controllers\Controller;

use Celebgramme\Helpers\GeneralHelper;

use Celebgramme\Models\EmailUser;
use Celebgramme\Models\Phone;

use View,Auth,Request,DB,Carbon,Excel, Mail, Validator, Input, Config;

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
		if (Request::input('keyword')=="") {
			$data = EmailUser::paginate(15);
		}else {
			$data = EmailUser::
								where("email",'like',"%".Request::input('keyword')."%")
								->orWhere("fullname",'like',"%".Request::input('keyword')."%")
								->paginate(15);
		}
    return view('admin.email.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_email_users()
  {
		if (Request::input('keyword')=="") {
			$data = EmailUser::paginate(15);
		}else {
			$data = EmailUser::
								where("email",'like',"%".Request::input('keyword')."%")
								->orWhere("fullname",'like',"%".Request::input('keyword')."%")
								->paginate(15);
		}
    return view('admin.email.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add user email berhasil dilakukan";
		
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = Input::file('fileExcel')->getClientOriginalName().date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
				$reader->calculate(false);
			})->get();
			$flag = false;
			$error_message="";
			// dd($readers);
			foreach($readers as $sheet)
			{
				if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						// try {
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


							$email_user = EmailUser::where("email","=",strtolower($row->email))->first();
							if (is_null($email_user)) {
								$email_user = new EmailUser;
								$email_user->email = $row->email;
								$email_user->fullname = $row->name;
								$email_user->save();
							} else {
							}
						// } catch (Exception $e) {
							// continue;
						// }
						
					}
				}
			}
		
		return $arr;
	}

	public function delete_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete email berhasil dilakukan";
		
		$email_user = EmailUser::truncate();
		
		return $arr;
	}

	public function export_email_users()
  {
		$arr = EmailUser::all();
		Excel::create(date("F j, Y, g:i a"), function($excel) use ($arr) {
      $excel->sheet('keywords', function($sheet)use ($arr)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data->fullname,$data->email
					));
				}
      });
		})->download('xls');
	}

	public function download_template_email()
  {
		Excel::create("Email Template", function($excel) {
      $excel->sheet('Sheet1', function($sheet)  {
				$sheet->appendRow(array(
						"name","email"
				));
      });
      $excel->sheet('Sheet2', function($sheet)  {
      });
      $excel->sheet('Sheet3', function($sheet)  {
      });
		})->export('xlsx');
	}

	
	/*
	PHONE
	*/
	public function index_phone()
	{
    $user = Auth::user();
		return View::make('admin.phone.index')->with(
                  array(
                    'user'=>$user,
                  ));
  }
  
	public function load_phone_users()
  {
    $user = Auth::user();
		if (Request::input('keyword')=="") {
			$data = Phone::paginate(15);
		}else {
			$data = Phone::
								where("Phone",'like',"%".Request::input('keyword')."%")
								->orWhere("fullname",'like',"%".Request::input('keyword')."%")
								->paginate(15);
		}
    return view('admin.Phone.content')->with(
                array(
                  'user'=>$user,
                  'data'=>$data,
                  'page'=>Request::input('page'),
                ));
  }

	public function pagination_phone_users()
  {
		if (Request::input('keyword')=="") {
			$data = Phone::paginate(15);
		}else {
			$data = Phone::
								where("Phone",'like',"%".Request::input('keyword')."%")
								->orWhere("fullname",'like',"%".Request::input('keyword')."%")
								->paginate(15);
		}
    return view('admin.Phone.pagination')->with(
                array(
                  'data'=>$data,
                ));
  }

	public function add_phone_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses add user email berhasil dilakukan";
		
			if (Input::file('fileExcel')->isValid()) {
				// $destinationPath = 'uploads'; // upload path
				$destinationPath = base_path().'/public/admin/uploads/temp/';
				$extension = Input::file('fileExcel')->getClientOriginalExtension(); 
				$fileName = Input::file('fileExcel')->getClientOriginalName().date('Y_m_d_H_i_s').'.'.$extension; 
				Input::file('fileExcel')->move($destinationPath, $fileName);
			} else {
				$arr['type'] = "error";
				$arr['message'] = "File tidak valid";
				return $arr;
			}
			
			Config::set('excel.import.startRow', '1');
			$readers = Excel::load($destinationPath.$fileName, function($reader) {
				$reader->calculate(false);
			})->get();

			$flag = false;
			$error_message="";
			foreach($readers as $sheet)
			{
				// if ($sheet->getTitle()=='Sheet1') {
					foreach($sheet as $row)
					{
						if ( ($row->name=="") && ($row->phone=="") )  {
							continue;
						}
						



						$email_user = Phone::where("phone","=",$row->phone)->first();
						if (is_null($email_user)) {
							$email_user = new Phone;
							$email_user->phone = $row->phone;
							$email_user->fullname = $row->name;
							$email_user->save();
						} else {
						}

						
					}
				// }
			}
		
		return $arr;
	}

	public function delete_phone_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses delete email berhasil dilakukan";
		
		$email_user = Phone::truncate();
		
		return $arr;
	}

	public function export_phone_users()
  {
		$arr = Phone::all();
		Excel::create(date("F j, Y, g:i a"), function($excel) use ($arr) {
      $excel->sheet('keywords', function($sheet)use ($arr)  {
				foreach ($arr as $data) { 
					$sheet->appendRow(array(
							$data->fullname,$data->phone
					));
				}
      });
		})->download('xls');
	}

	public function download_template_phone()
  {
		Excel::create("Phone Template", function($excel) {
      $excel->sheet('Sheet1', function($sheet)  {
				$sheet->appendRow(array(
						"name","phone"
				));
      });
      $excel->sheet('Sheet2', function($sheet)  {
      });
      $excel->sheet('Sheet3', function($sheet)  {
      });
		})->export('xlsx');
	}

	
	
	public function edit_email_users()
  {
    $arr["type"] = "success";
    $arr["message"] = "Proses edit user email berhasil dilakukan";
		
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
					$replace_content = str_replace("/nama/", $emailuser->fullname, $content);
					$replace_subject = str_replace("/nama/", $emailuser->fullname, $subject);
					$emaildata = [
							'content' => $replace_content,
					];
					Mail::queue('emails.content', $emaildata, function ($message) use ($emailuser,$replace_subject) {
						$message->from('no-reply@celebgramme.com', 'Celebgramme');
						$message->to($emailuser->email);
						$message->subject($replace_subject);
					});
			
		}
		return "";
	}

	
	
}
