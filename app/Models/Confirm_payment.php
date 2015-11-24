<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Confirm_payment extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'confirm_payments';
	protected $primaryKey  = 'id';
  protected $fillable = ['total','no_invoice'];
    
	public $timestamps = false;
}
