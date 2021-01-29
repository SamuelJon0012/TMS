<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyVaccinesController extends Controller
{
    // Check for any vaccine data updates and provide the initial static My Vaccines modal data on page load

    function index(Request $request) {

        return $this->getVaccineModalData($request->get('id'));

    }


    function getVaccineModalData($userId) {

        return false;
    }

}
