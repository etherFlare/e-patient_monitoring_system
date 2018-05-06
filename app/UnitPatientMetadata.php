<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class UnitPatientMetadata extends Model
{
	protected $table = 'unit_patient_metadata';
	protected $fillable = [
		'unit_id',
		'mac',
		'sensor_type',
		'sensor_value'
	];
	public function type()
	{
		return $this->belongsTo('App\Type');
	}
	 public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
