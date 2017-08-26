<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'temps';
	public $timestamps = false;
}
