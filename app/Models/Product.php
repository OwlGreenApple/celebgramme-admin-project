<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'products';
	protected $primaryKey  = "id";
	protected $fillable = [
		'product_name',
		'product_slug',
		'product_price',
		'product_view',
		'product_discount',
		'product_condition',
		'product_location',
		'product_description',
		'product_stock',
		'product_weight',
		'product_categories_id',
		'supplier_id',
	];
	public $timestamps = false;
}
