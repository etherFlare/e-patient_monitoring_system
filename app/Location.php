<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $table = 'locations';
	protected $fillable = [
		'name',
		'description'
	];
	public function patients()
	{
		return $this->hasMany('App\Patient');
	}

}
