<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientUser extends Model
{
	protected $table = 'patient_user';
	protected $fillable = [
		'patient_id',
		'user_id',
	];
}
