<?php namespace Celebgramme\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract {


	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admins';
  
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    public $timestamps = false;
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    /*
    * this user creates many logs
    */
    public function logs ()
    {
      return $this->hasMany('Celebgramme\Models\Admin_logs');
    }

}
