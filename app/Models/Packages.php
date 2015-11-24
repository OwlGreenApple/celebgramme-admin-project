<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Packages extends Model {
	protected $connection 	= 'mysql_axs';
	protected $table 			= 'packages';
	public $timestamps 		= false;
	protected $fillable 			= ['package_name','package_price'];
}
