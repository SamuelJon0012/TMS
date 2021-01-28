<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\EncounterSchedule;
use App\PatientProfile;
use App\SiteProfile;
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

        if ($B->login($request->get('username'), $request->get('password')) === false) {
            // Todo: Login failed

        }
    }

    function find(Request $request)
    {

        $Q = $request->get('q');

        $I = $request->get('i'); // which input element was used (search-input, provider-search-input, ...)

        # Todo: sanitize Q to prevent hackery
        #$Q = $this->sanitize($Q);

        if (empty($Q)) {

            # Todo or len q < 3 or something

        }

        if (empty($I)) {

            $I = 'search-input';

        }


        # Todo: have a method that determines the query type based on the contents of Q,
        # i.e. last,first vs first last vs me@moo.cow vs. ###-###-####

        #$type = $this->getSearchType($Q);

        $P = new PatientProfile('erik.olson@trackmysolutions.us', 'Mermaid7!!');

        $type = 'any'; // or allow them to specify the type?  i.e. type=ssn by searching on ssn:xxx-xx-xxxx

        # or make type be an object where getSearchType has parsed out all the potential fields to search on for that type

        if ($I != 'provider-search-input') {
            $where = "SELECT *";
            $where .= " FROM patient_profile AS p";
        } else {
            $where = "SELECT p.*";
            $where .= " FROM patient_profile AS p JOIN encounter_schedule AS e ON e.patient_id=p.id";
        }

        switch ($type) {

            case 'any':
            default:

                # How do you search on node and node[]s? i.e. phone_number)

                $where .= " WHERE asset.address1 ILIKE '%$Q%' OR asset.first_name ILIKE '%$Q%' OR asset.last_name  ILIKE '%$Q%' OR asset.email ILIKE '%$Q%' OR asset.ssn ILIKE '%$Q%' OR asset.dl_number ILIKE '%$Q%' OR asset.first_name ILIKE '%$Q%'";

                # can't have carriage returns?
        }

        if ($I == 'provider-search-input') {

            if (session('provider', false)) {

                $where = $where . ' AND e.site_id=0'; // .session('provider');

            }
        }
        // TESTING $where = $where . ' AND e.site_id=1';

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }
        //$dummy = $P->getData();

        $rows = $P->array();

        return $this->success($rows);
    }

    function get(Request $request)
    {

        $Q = $request->get('q');

        # Todo: sanitize Q to prevent hackery
        #$Q = $this->sanitize($Q);

        if (empty($Q)) {

            # Todo or something
        }
        $P = new PatientProfile('erik.olson@trackmysolutions.us', 'Mermaid7!!');

        $where = "WHERE asset.id=$Q";

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }
        $rows = $P->array();

        # ToDo
        # Make this a join in the Model, but for now I'm getting strange results when I try to use JOIN
        # SELECT * FROM patient_profile AS p
        # INNER JOIN encounter_schedule AS s ON s.patient.id=p.id WHERE p.first_name LIKE '%e%'
        # results in no data or strangely scrambled data

        //$E = new EncounterSchedule('erik.olson@trackmysolutions.us', 'Mermaid7!!');


        $E = new EncounterSchedule(); # should reuse the login
        $where = "WHERE asset.patient_id=$Q";
        $dummy = $E->find($where);
        $rows[0]['schedule'] = $E->array();

        $where = "WHERE asset.id=" . $E->getSiteId();
        $S = new SiteProfile();
        $dummy = $S->find($where);
        $rows[0]['site'] = $S->array();
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
            'data' => $data,
        ]);
    }
}
