<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'phones';
	public $timestamps = false;
}
