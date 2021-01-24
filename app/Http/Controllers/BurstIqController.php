<?php

namespace App\Http\Controllers;

use App\BurstIq;
use Illuminate\Http\Request;

/**
 * Class BurstIqController
 * @package App\Http\Controllers
 */
class BurstIqController extends Controller
{
    // Ajax Endpoints for BurstIq IO

    /**
     * @return bool|string
     *
     * This is a simple health-check on the API
     *
     */
    function status() {

        $B = new BurstIq();

        return $B->status();
    }

    /**
     * @param Request $request
     * @return mixed
     *
     * expects username and password parameters
     *
     * returns JWT (it's also kept in session)
     *
     */
    function login(Request $request) {

        $B = new BurstIq();

        return $B->login($request->get('username'), $request->get('password'));
    }

}
