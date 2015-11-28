<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'invoices';
	protected $primaryKey  = "id";
	protected $fillable = [
	];
}
