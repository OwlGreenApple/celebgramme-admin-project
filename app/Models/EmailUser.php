<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class EmailUser extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'emails';
	public $timestamps = false;
}
