<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'orders';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
	use SoftDeletes;
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}
