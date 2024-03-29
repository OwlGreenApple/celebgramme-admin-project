<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'packages';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
	public $timestamps = false;
	use SoftDeletes;
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}
