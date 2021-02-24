<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    protected $table = 'sites';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'vicinity_name', 'address1', 'city', 'state', 'zipcode', 'county', 'vsee_clinic_id','room_code'];
}
