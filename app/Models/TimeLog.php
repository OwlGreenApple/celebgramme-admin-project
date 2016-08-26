<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'time_logs';
	public $timestamps = false;
}
