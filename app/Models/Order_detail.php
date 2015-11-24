<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'order_details';
	protected $primaryKey  = 'id';
  protected $fillable = ['order_id','product_id','product_name','product_price','product_quantity','product_filename'];
    
	public $timestamps = false;
}
