<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientUser extends Model
{
	protected $table = 'patient_obeserver';
	protected $fillable = [
		'patient_id',
		'user_id',
	];
}
