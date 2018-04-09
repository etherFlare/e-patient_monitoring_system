<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'unit_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'age',
        'location_id',
        'home_address',
        'contact_number',
        'contact_person',
        'is_active',
        'is_archive',
        'comment'
    ];
        public function location()
    {
        return $this->belongsTo('App\Location');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
        public function normal()
    {
        return $this->hasMany('App\NormalReference');
    }
    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withPivot('context', 'status')
            ->withTimestamps();
    }
}
