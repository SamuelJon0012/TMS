<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlertsController extends Controller
{
    // Check for any alerts and provide the initial static alert modal data on page load

    function index(Request $request) {

        return $this->getAlertsModalData($request->get('id'));

    }

    function getAlertsModalData($userId) {


        return false;

    }




}
