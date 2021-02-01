<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Update, Refresh, and set initial modal data content on page load

    function index(Request $request) {

        return $this->getLocationModalData($request->get('id'));

    }


    function getLocationModalData($userId) {

        return false;
    }
}
