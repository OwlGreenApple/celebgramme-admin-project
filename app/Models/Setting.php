<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Setting extends Model {

	/**
	 * untuk koneksi ke database utama
	 *
	 * @var string
	 */
	protected $connection = 'mysql_axs';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['setting_key','setting_value'];
	public 		$timestamps = false;
	
	protected function setValue($key, $value)
	{
		$setting = Setting::where('setting_key', '=', $key)->first();
		if ($setting == null){
			$setting = new Setting;
			$setting->setting_key = $key;
		}
		if ($value == null){
			$setting->delete();
		}
		else{
			$setting->setting_value = $value;
			$setting->save();
		}
	}
	
	protected function getValue($key)
  {       
    $setting = Setting::where('setting_key', '=', $key)->first();
    if ($setting != null){
      return $setting->setting_value;
    }
    else{
      return '';
    }
  }
}
