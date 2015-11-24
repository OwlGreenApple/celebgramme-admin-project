<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'orders';
	protected $primaryKey  = 'id';
  protected $fillable = ['no_order','order_total','order_subtotal','order_shipment_fee','customer_id','shipping_number','invoice_id','referral_id','order_payment_status','order_shipping_status','shipping_method','payment_method'];
    
	public $timestamps = false;
}
