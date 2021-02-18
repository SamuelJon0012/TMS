<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\Encounter;
use App\Encounters;
use App\EncounterSchedule;
use App\PatientProfile;
use App\SiteProfile;
use App\Visits;
use App\VSee;
use Illuminate\Http\Request;

/**
 * Class BurstIqController
 * @package App\Http\Controllers
 */
class BurstIqController extends Controller
{
    // Ajax Endpoints for BurstIq IO
    // const BI_USERNAME = 'sabbaas@gmail.com'; // Todo: get this from .env
    // const BI_PASSWORD = 'TrackMy21!';
    private $BI_USERNAME;
    private $BI_PASSWORD;

    public function __construct()
    {
//        $this->BI_USERNAME = env('BI_USERNAME');
//        $this->BI_PASSWORD = env('BI_PASSWORD');
    }

    function redirect()
    {

        // Save quest form and return vsee.redirect view which redirects the person to Vsee

        //$B = new BurstIq();

        $data = json_encode($_POST);

        file_put_contents ('/var/www/data/' . uniqid(true), $data);

        return view('vsee.redirect');


    }


    /**
     * @return bool|string
     *
     * This is the barcode from the scanner
     *
     */
    function barcode()
    {

        $data=json_encode($_REQUEST);

        $patient_id = $_REQUEST['patient_id'];
        $barcode = $_REQUEST['barcode'];

        file_put_contents ('/var/www/data/bc' . uniqid(true), $data);

        exit("Stored barcode $barcode for Patient ID $patient_id");

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

//        $B = new BurstIq();
//
//        if ($B->login($request->get('username'), $request->get('password')) === false) {
//            // Todo: Login failed
//
//        }
    }

    function find(Request $request)
    {

        $Q = BurstIq::escapeString($request->get('q'));

        $I = $request->get('i'); // which input element was used (search-input, provider-search-input, ...)

        if (empty($Q)) {

            # Todo or len q < 3 or something

        }

        if (($I != 'search-input') and ($I != 'provider-search-input'))
          $I = 'search-input';

        $type = self::getSearchType($Q);

        $P = new PatientProfile($this->BI_USERNAME,$this->BI_PASSWORD);

        if ($I != 'provider-search-input') {
            $where = "SELECT *";
            $where .= " FROM patient_profile AS p";
        } else {
            $where = "SELECT p.*";
            $where .= " FROM patient_profile AS p JOIN encounter_schedule AS e ON e.patient_id=p.id";
        }

        switch ($type) {
            case 'null':
                $where .= " WHERE (1=1) ";
                break;

            case 'email':
                $where .= " WHERE asset.email ILIKE '%$Q%' ";
                break;
            
            case 'ssn':
                $where .= " WHERE asset.ssn = '$Q' ";
                break;

            case 'lastNameFirst':
                $a = explode(',', $Q, 2);
                $firstName = trim($a[1]);
                $lastName = trim($a[0]);
                $where .= " WHERE asset.first_name ILIKE '%$firstName%' and asset.last_name  ILIKE '%$lastName%' ";
                break;

            case 'names':
                $a = explode(' ', $Q, 2);
                $firstName = trim($a[0]);
                $lastName = trim($a[1]);
                $where .= " WHERE asset.first_name ILIKE '%$firstName%' and asset.last_name  ILIKE '%$lastName%' ";
                break;

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

        $where .= ' LIMIT 100 '; // TODO: Are we going to use pagination? 

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }
        //$dummy = $P->getData();

        $rows = $P->array();

        return $this->success($rows);
    }

    function encounters(Request $request) {

        $Q = $request->get('q');
        $Q = (is_numeric($Q)) ? (int)$Q : 0;
        if ($Q == 0)
            abort(403, 'Invalid Patient ID');
        
        if ($Q < 40) {
            $Q = 111;
        }

        $result = Encounters::where('patient_id', $Q)->first();


        if (empty($result)) {
            exit("Vaccination data for Patient has not been posted");
        }

        $result = $result->toArray();

        $barcode = $result['barcode'];

        $barray = explode('_', $barcode . '_not scanned');

        $ndc = $barray[1];

        $result['ndc'] = $ndc;

        #var_dump($result);exit; // Todo adjust datetime to local timezone

        return view('app.my_vaccines', $result);

        // IDK why the below isn't working

        $E = new Encounter();

        $where = "WHERE asset.patient_id=$Q";

        if (!$E->find($where)) {
            return $this->error('Vaccination data for Patient $Q has not been posted');
        } else {
            $rows = $E->array();
            var_dump($rows);
        }


    }

    function get(Request $request)
    {

        $Q = $request->get('q');
        $Q = (is_numeric($Q)) ? (int)$Q : 0;
        if ($Q == 0)
            abort(403, 'Invalid Patient ID');

        $P = new PatientProfile();

        $where = "WHERE asset.id=$Q";

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }
        $rows = $P->array(); // Get Patient Data for Display Only (Enumerations converted, joins, etc)

        # ToDo - Use Abbas' new join model (see BurstIqTestController@testGettingPatientScheduleSiteQuery)
        # Make this a join in the Model, but for now I'm getting strange results when I try to use JOIN
        # SELECT * FROM patient_profile AS p
        # INNER JOIN encounter_schedule AS s ON s.patient.id=p.id WHERE p.first_name LIKE '%e%'
        # results in no data or strangely scrambled data

        # ^ Belay that order, Ensign



//        $E = new EncounterSchedule(); <----- This needs to be reconsidered
//
//        $where = "WHERE asset.patient_id=$Q";
//        $dummy = $E->find($where);
//        $rows[0]['schedule'] = $E->array();

        $V = new VSee();

        $first = $rows[0]['first_name'];
        $last = $rows[0]['last_name'];
        $dob = (array)$rows[0]['date_of_birth'];

        $dob = $dob['$date'];
        $dob = substr($dob,0,10);
        $email = $rows[0]['email'];

        $data = $V->getVisits($first, $last, $dob, $email);

        if ($data === false) {

            $rows[0]['schedule1'] = [
                'date' => '',
                'time' => '',
                'location' => 'Appt Not Set'
            ];

        } else {

            $data = json_decode($data);

            if (isset($data->data[0]->start)) {

                $timestamp = $data->data[0]->start;

                $gmdate = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $date = gmdate("Y-m-d", $timestamp);
                $time = gmdate("H:i", $timestamp);
                $location = $data->data[0]->room->name;

                $rows[0]['schedule1'] = [

                    'date' => $date,
                    'time' => $time,
                    'location' => $location

                ];

            } else {

                    $rows[0]['schedule1'] = [
                        'date' => '',
                        'time' => '',
                        'location' => 'No Appointment Data'
                    ];


            }

            if (isset($data->data[1]->start)) {

                $timestamp = $data->data[1]->start;

                $gmdate = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $date = gmdate("Y-m-d", $timestamp);
                $time = gmdate("H:i", $timestamp);
                $location = $data->data[1]->room->name;

                $rows[0]['schedule2'] = [

                    'date' => $date,
                    'time' => $time,
                    'location' => $location

                ];

            }

            if (isset($data->data[2]->start)) {

                $timestamp = $data->data[2]->start;

                $gmdate = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                $date = gmdate("Y-m-d", $timestamp);
                $time = gmdate("H:i", $timestamp);
                $location = $data->data[2]->room->name;

                $rows[0]['schedule3'] = [

                    'date' => $date,
                    'time' => $time,
                    'location' => $location,
                    'total_count' => $data->total_count,
                    'more' => $data->total_count - 3,

                ];



            }



        }

        #$where = "WHERE asset.id=" . $E->getSiteId();
//        $where = "WHERE asset.id=1";
//        $S = new SiteProfile();
//        $dummy = $S->find($where);
//        $rows[0]['site'] = $S->array();
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

    static function getSearchType($txt){
        if (!isset($txt))
            return 'null';
        
        $val = new \Egulias\EmailValidator\EmailValidator();
        if ($val->isValid($txt, new \Egulias\EmailValidator\Validation\RFCValidation()))
            return 'email';
        
        if (preg_match('/^(?!666|000|9\\d{2})\\d{3}-(?!00)\\d{2}-(?!0{4})\\d{4}$/', $txt))
            return 'ssn';

        if (preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im', $txt))
            return 'phone';
        
        $a = explode(',', $txt);
        if (count($a) == 2)
            return 'lastNameFirst';
        
        $a = explode(' ', $txt);
        if (count($a) == 2)
            return 'names';
        
        return 'any';
    }
}
