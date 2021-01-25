<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\PatientProfile;
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
    function status()
    {

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
    function login(Request $request)
    {

        $B = new BurstIq();

        return $B->login($request->get('username'), $request->get('password'));
    }

    function find(Request $request)
    {

        $Q = $request->get('q');

        # Todo: sanitize Q to prevent hackery
        #$Q = $this->sanitize($Q);

        if (empty($Q)) {

            # Todo or len q < 3 or something

        }

        # Todo: have a method that determines the query type based on the contents of Q,
        # i.e. last,first vs first last vs me@moo.cow vs. ###-###-####

        #$type = $this->getSearchType($Q);

        $P = new PatientProfile('erik.olson@trackmysolutions.us', 'Mermaid7!!');

        $type = 'any'; // or allow them to specify the type?  i.e. type=ssn by searching on ssn:xxx-xx-xxxx

        # or make type be an object where getSearchType has parsed out all the potential fields to search on for that type

        switch ($type) {

            case 'any':
            default:

                # How do you search on node and node[]s? i.e. phone_number)
                $where = "SELECT id, CONCAT(asset.first_name, ', ', asset.last_name) as name, asset.date_of_birth, asset.email, asset.phone_numbers";
                $where .= " FROM patient_profile";
                $where .= " WHERE asset.address1 ILIKE '%$Q%' OR asset.first_name ILIKE '%$Q%' OR asset.last_name  ILIKE '%$Q%' OR asset.email ILIKE '%$Q%' OR asset.ssn ILIKE '%$Q%' OR asset.dl_number ILIKE '%$Q%' OR asset.first_name ILIKE '%$Q%'";

                # can't have carriage returns?
        }

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }
        //$dummy = $P->getData();

        $rows = $P->array();

        return $this->success($rows);
    }

    function error($msg = 'An error has occurred')
    {

        return response()->json([
            'success' => false,
            'message' => $msg,
        ]);
    }

    function success($data)
    {

        return response()->json([
            'success' => true,
            'data' => (array)$data,
        ]);
    }
}
