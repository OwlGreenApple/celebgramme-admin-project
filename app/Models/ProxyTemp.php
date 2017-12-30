<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class ProxyTemp extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'proxy_temps';
	public $timestamps = false;
}
