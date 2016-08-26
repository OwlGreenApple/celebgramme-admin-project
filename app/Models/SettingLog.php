<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLog extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'setting_logs';
	public $timestamps = false;
}
