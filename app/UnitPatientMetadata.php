<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitPatientMetadata extends Model
{
		protected $table = 'unit_patient_metadata';
	       protected $fillible = [
	  			'uniy_id',
	            'sensor_type',
	            'sensor_value'
	       ];
}
