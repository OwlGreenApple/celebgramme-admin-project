<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'orders';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
}
