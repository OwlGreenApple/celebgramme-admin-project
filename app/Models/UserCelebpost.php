<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;


class UserCelebpost extends Model {

	protected $table = 'users';
	protected $connection = 'mysql_celebpost';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ ];
}
