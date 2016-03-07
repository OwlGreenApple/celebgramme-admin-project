<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class PostLog extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'post_logs';
	public $timestamps = false;
}
