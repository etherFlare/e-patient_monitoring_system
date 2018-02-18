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
        'location',
        'home_address',
        'contact_number',
        'contact_person',
        'is_active',
        'is_archive',
        'comment'
    ];
}
