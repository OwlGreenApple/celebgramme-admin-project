<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Package_metas extends Model {
	protected $connection 	= 'mysql_axs';
	protected $table 			= 'package_metas';
	public $timestamps 		= false;
	protected $fillable 			= ['meta_name','meta_value','package_id'];
}
