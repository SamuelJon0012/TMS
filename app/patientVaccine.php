<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class patientVaccine extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'name',
        'vaccine_name',
        'dose_number',
        'lot_number',
        'manufacturer',
        'dose_date',
        'health_pro'
    ];
}
