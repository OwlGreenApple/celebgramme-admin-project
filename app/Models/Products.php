<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Products extends Model {
	protected $connection 	= 'mysql_axs';
	protected $table 			= 'products';
	public $timestamps 		= false;
	protected $fillable 			= ['product_name',
												'product_slug',
												'product_price',
												'product_view',
												'product_discount',
												'product_condition',
												'product_location',
												'product_description',
												'product_stock',
												'product_weight',
												'created_at',
												'updated_at',
												'product_categories_id',
												'supplier_id'];
}
