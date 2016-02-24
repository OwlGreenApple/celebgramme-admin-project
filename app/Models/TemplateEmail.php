<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;

use Celebgramme\Helpers\GeneralHelper;
use Carbon\Carbon;

class TemplateEmail extends Model {

	protected $table = 'template_emails';
	public $timestamps = false;
  
	protected function createMeta()
	{
  }
  
}
