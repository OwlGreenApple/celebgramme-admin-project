<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class OrderMeta extends Model {

	/**
	 * untuk koneksi ke database utama
	 *
	 * @var string
	 */
	protected $connection = 'mysql_axs';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order_metas';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['meta_name','meta_value','order_id'];
	public 		$timestamps = false;
	
	protected function setMeta($ref_id, $meta_name, $meta_value)
	{
		$meta = OrderMeta::where('meta_name', '=', $meta_name)->where('order_id', '=', $ref_id)->first();
		if ($meta == null){
			$meta = new OrderMeta;
			$meta->meta_name = $meta_name;
			$meta->order_id = $ref_id;
		};
		if ($meta_value == null){
			$meta->delete();
		}
		else{
			$meta->meta_value = $meta_value;
			$meta->save();
		}
	}
	
	protected function getMeta($ref_id, $meta_name)
  {       
    $meta = OrderMeta::where('meta_name', '=', $meta_name)->where('no_order', '=', $ref_id)->first();
    if ($meta != null){
      return $meta->meta_value;
    }
    else{
      return '';
    }
  }
}
