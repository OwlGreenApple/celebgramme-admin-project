<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class ProxyLogin extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'proxy_logins';
	public $timestamps = false;
}
