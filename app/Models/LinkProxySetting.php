<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class LinkProxySetting extends Model {
	protected $connection = 'mysql_axs';
	protected $table = 'link_proxies_settings';
}
