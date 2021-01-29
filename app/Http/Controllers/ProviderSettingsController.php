<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderSettingsController extends Controller
{
    // Refresh, Update, and provide initial Provider Settings Modal Data on page load

    function index(Request $request) {

        return $this->getProviderSettingsModalData($request->get('id'));

    }


    function getProviderSettingsModalData($userId) {

        return false;
    }
}
