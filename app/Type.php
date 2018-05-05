<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
	protected $fillable = [
		'name',
		'description'
	];
	public function metadata()
	{
		return $this->hasMany('App\UnitPatientMetadata');
	}
	public function normal()
	{
		return $this->hasMany('App\NormalReference');
	}
}
