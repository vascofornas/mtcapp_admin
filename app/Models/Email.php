<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use DB;

class Email extends Model {

	protected $table = 'emails';

	protected $primary = "name";

	public $incrementing = false;

	public $timestamps = false;

}
