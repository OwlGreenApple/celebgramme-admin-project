<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'packages';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
	public $timestamps = false;
}
