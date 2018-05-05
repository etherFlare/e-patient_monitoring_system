<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalReference extends Model
{
	protected $table = 'normals';
	protected $fillable = [
		'patient_id',
		'type_id',
		'upper_limit',
		'lower_limit'
	];
	public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
    public function type()
    {
        return $this->belongsTo('App\Type');
    }
}
