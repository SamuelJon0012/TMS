<?php

namespace App\Http\Controllers;

use App\BurstIq;
use Illuminate\Http\Request;

class BurstIqController extends Controller
{
    // Ajax Endpoints for BurstIq IO

    function status() {

        $B = new BurstIq();

        return $B->status();
    }

    function login(Request $request) {

        $B = new BurstIq();

        return $B->login($request);
    }

    function test(Request $request) {

        $B = new BurstIq();

        #$B->login($request);

        return $B->query('patient_profile',"WHERE asset.id = 123");
    }

    function test2(Request $request) {

        $B = new BurstIq();

        #$B->login($request);

        $postFields = '{
            "id": 123,
            "email": "DoctorKnockers@hotmail.com",
            "first_name": "Jacques",
            "last_name": "Clouseau",
            "relationship_to_owner": "Self",
            "date_of_birth":"1/1/2000",
            "address1":"123 Sesame St",
            "address2":"Apt 123.5",
            "city":"New York",
            "state":"NY",
            "zipcode":"01234",
            "ssn":"123-45-6789",
            "dl_state":"NY",
            "dl_number":"C425212652790",
            "ethnicity":"French",
            "race":"W",
            "phone_numbers": [{
                "is_primary":"1",
                "phone_type":"M",
                "phone_number": "+334444444444"
                }],
            "insurance": [{
                "administrator_name":"Bob",
                "group_id":"123456",
                "employer_name":"French Surete",
                "coverage_effective_date":"1/1/2021",
                "issuer_id":"654321",
                "primary_cardholder":"CLOUSEAU, JACQUES",
                "patient_profile_id":"123",
                "insurance_type":1
                }]
            }';

        return $B->upsert('patient_profile', $postFields);

    }


}
