<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product_metas extends Model {
	protected $connection 	= 'mysql_axs';
	protected $table 			= 'product_metas';
	public $timestamps 		= false;
	protected $fillable 			= ['meta_name',
												'meta_value',
												'product_id'];
}
