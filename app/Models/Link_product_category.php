<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Link_product_category extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'link_products_categories';
	protected $primaryKey  = 'id';
  protected $fillable = [];
    
	public $timestamps = false;
}
