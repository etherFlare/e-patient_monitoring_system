<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    protected $fillable = [
        'label',
		'mac_address',
        'unit_is_active',
        'unit_is_inuse',
        'oximeter_is_active',
        'bp_is_active',
        'thermometer_is_active',
        'oximeter_delay',
        'bp_delay',
        'thermometer_delay',
        'comment'

    ];

    public function patients()
    {
        return $this->hasMany('App\Patient'); 
    }
    public function unit()
    {
        return $this->hasOne('App\Unit'); 
    }
}
