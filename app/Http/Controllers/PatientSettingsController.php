<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientSettingsController extends Controller
{
    // Refresh, Update, and provide initial Patient Settings Modal Data on page load

    function index(Request $request) {

        return $this->getPatientSettingsModalData($request->get('id'));

    }


    function getPatientSettingsModalData($userId) {

        return false;
    }
}
