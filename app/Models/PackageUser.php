<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class PackageUser extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'packages_users';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
}
