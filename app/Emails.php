<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $fillable = [
        'id',
        'name',
        'dob',
        'gender',
        'language',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'cellphone',
        'chiro',
        'facility',
        'doi',
        'insurance',
        'claim',
        'requested_date',
        'requested_time',
        'new_requested_date',
        'new_requested_time',
        'email_file',
        'first_name',
        'last_name',
    ];

    public $timestamps = false;

}