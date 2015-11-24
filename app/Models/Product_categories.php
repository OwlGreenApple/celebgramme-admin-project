<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product_Categories extends Model {
	protected $connection 	= 'mysql_axs';
	protected $table 			= 'product_categories';
	public $timestamps 		= false;
	protected $fillable 			= ['category_name',
												'category_description',
												'category_slug',
												'category_type',
												'category_image',
												'parent_id'];
}
