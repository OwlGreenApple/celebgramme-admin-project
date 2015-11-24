<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Celebgramme\Models\Admin_logs;
use Auth;
class Admin_logs extends Model {

	protected $connection 	= 'mysql_axs';
	protected $table 			= 'admin_logs';
    protected $primaryKey  	= "id";
    protected $dates       		= ["created"];
    protected $fillable = array(
                'admin_log_description','admin_log_type','admin_id','foreign_id','created'
    );
    
    public $timestamps = false;
    
    /* Log the current activity 
    *
    *@param text $description
    *@param request $request
    *@param string $type
    *@param int $foreign
    */
    public static function log_activity($description,$request,$type,$foreign)
    {
        $act = $description.": ";
        if(is_string($request)){
            $act .= $request;
        }elseif(is_array($request) && (!empty($request))){
            foreach ($request as $key => $value) {
                $act .= $key." = ".$value.", ";
            }
        }elseif(empty($request)){
            $act = "tak ada field yang ter".$description;
        }else{
            $request = $request->except("_method","_token");    
            
            foreach ($request as $key => $value) {
                $act .= $key." = ".$value.", ";
            }
        }
        $admin = Auth::user();
        $array = [
            "admin_log_description"=>$act,
            "admin_log_type"=>$type,
            "admin_id"=>$admin->id,
            "foreign_id"=>$foreign,
            "created"=>Carbon::now()
        ];
        Admin_logs::create($array);
    }
}
