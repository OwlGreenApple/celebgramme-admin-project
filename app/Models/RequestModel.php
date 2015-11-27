<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'requests';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
}
