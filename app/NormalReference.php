<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalReference extends Model
{
	protected $table = 'normal_reference';
	protected $fillable = [
		'type',
		'upper_limit',
		'lower_limit'
	];
}
