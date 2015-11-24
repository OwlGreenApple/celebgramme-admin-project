<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model {

	protected $connection = 'mysql_axs';
	protected $table = 'suppliers';
	protected $primaryKey  = 'id';
  protected $fillable = ['supplier_company_name','supplier_address','supplier_phone'];
    
	public $timestamps = false;
}
