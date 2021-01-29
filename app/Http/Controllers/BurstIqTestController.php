<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\DrugProfile;
use App\Encounter;
use App\EncounterSchedule;
use App\PatientProfile;
use App\ProcedureResults;
use App\ProviderProfile;
use App\QuestionProfile;
use App\SiteProfile;
use App\PatientScheduleSiteQuery;
use Illuminate\Http\Request;

class BurstIqTestController extends Controller
{
    // Ajax Endpoints for BurstIq IO
    private $BI_USERNAME;
    private $BI_PASSWORD;

    public function __construct()
    {
        $this->BI_USERNAME = env('BI_USERNAME');
        $this->BI_PASSWORD = env('BI_PASSWORD');
    }

    function status() {

        $B = new BurstIq();

        return $B->status();
    }

    function login(Request $request) {

        $B = new BurstIq();

        if ($B->login($this->BI_USERNAME,$this->BI_PASSWORD) === false) {
            // Todo: Login failed

        }
    }

    function testGettingAChain(Request $request) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $A = '';

        $B = new BurstIq($this->BI_USERNAME,$this->BI_PASSWORD);
        // $B = new BurstIq('sabbaas@gmail.com','TrackMy21!');

        #$where = "SELECT p.id AS id, e.patient_id AS pid FROM patient_profile AS p JOIN encounter_schedule AS e ON e.patient_id=p.id WHERE (p.first_name ILIKE '%jeff%' OR p.last_name ILIKE '%jeff%') AND e.site_id=1";
        #$where = "SELECT * FROM patient_profile AS p WHERE asset.first_name ILIKE '%jeff%'";
        #$where = "SELECT * FROM patient_profile WHERE asset.first_name ILIKE '%jeff%'";

        ###$where="SELECT p.asset.id AS id, e.asset.patient_id AS pid, e.asset.site_id as sid FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%')";
        ##$where="SELECT p.asset.*, e.asset.* FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%')";
        #$where="SELECT p.asset.*, e.asset.*, s.asset.* FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id LEFT OUTER JOIN site_profile AS s ON s.asset.id=e.asset.site_id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%')";
        //$where="SELECT p.asset.id AS id, e.asset.patient_id AS pid, e.asset.site_id as sid FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%') AND e.asset.site_id=1";
        $where="SELECT p.asset.*, e.asset.*, s.asset.* FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id LEFT OUTER JOIN site_profile AS s ON s.asset.id=e.asset.site_id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%')";


//        $A .= "\n\n" . $B->query('patient_profile',"WHERE asset.id >= 0");
//        $A .= "\n\n" . $B->query('provider_profile',"WHERE asset.id >= 0");
//        $A .= "\n\n" . $B->query('site_profile',"WHERE asset.id >= 0");
//        $A .= "\n\n" . $B->query('drug_profile',"WHERE asset.id >= 0");
//        $A .= "\n\n" . $B->query('question_profile',"WHERE asset.id = asset_id");
#        $A = $B->query('patient_profile',$where );
        $A = $B->query('site_profile',"WHERE asset.id >= 0" );
//        $A .= "\n\n" . $B->query('encounter',"WHERE asset.id >= 0");
//        $A .= "\n\n" . $B->query('procedure_results',"WHERE asset.id != 10");
//        $A .= "\n\n" . $B->query('user',"WHERE asset.id >= 0");
var_dump($A); exit;




    }

    function testGettingAPatient(Request $request) {

        #ini_set('display_errors', 1);
        #ini_set('display_startup_errors', 1);
        #error_reporting(E_ALL);

        $P = new PatientProfile($this->BI_USERNAME,$this->BI_PASSWORD);

        $where = "WHERE asset.address1 ILIKE '%Lucy%' OR asset.first_name ILIKE '%Lucy%' OR asset.last_name ILIKE '%Lucy%' OR asset.email ILIKE '%Lucy%' OR asset.ssn ILIKE '%Lucy%' OR asset.dl_number ILIKE '%Lucy%' OR asset.first_name ILIKE '%Lucy%'";

        if (!$P->find($where)) { // returns itself, or false if error Todo: hmmmm then you can't chain methods if there a error

            exit('Search produced an error');

        }

        $P->getData();  // full object returned from BurstIq (returns itself ($this) so you can chain methods if you want)

        $test = $P->array(); // Get an array of rows (arrays with sub ojects or sub arrays of sub objects)

        # iterate through the search results

        foreach ($test as $row) {

            var_dump($row);

            echo $row['first_name'] . ' ' . $row['last_name'] . '<br/>';

            # You must have only ONE resulting row in order to edit and save it
            # Otherwise the one you will edit and save will be the last one in the recordset

            // $P->find("WHERE asset.id = {$row['id']}");
            //
            // $P->setFirstName('Lucy')->save();

        }


        exit;

    }

    function testGettingAProvider(Request $request) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $P = new ProviderProfile($this->BI_USERNAME,$this->BI_PASSWORD);

        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq

        $test = $P->array(); // Get an array of rows (arrays with sub ojects or sub arrays of sub objects)

        # iterate through the search results

        foreach ($test as $row) {

            var_dump($row);

            #echo $row['first_name'] . ' ' . $row['last_name'] . '<br/>';
            echo $row['npi'] . '<br/>';

            # You must have only ONE resulting row in order to edit and save it
            # Otherwise the one you will edit and save will be the last one in the recordset

            $P->find("WHERE asset.id = {$row['id']}");

            $P->setNpi('ChangedMe!')->save();

        }
        exit;

    }
    function testUpsertingAPatient(Request $request) {

        $first_name = "Jack";
        $last_name = "Sprat";
        $address1 = "123 Sesame St";
        $address2 = "Unit 123";
        $city = "New YOrk";
        $state = "NY";
        $zipcode = "01234";
        $date_of_birth = "08/17/1965";
        $dl_number = "S425212652970";
        $dl_state = "NY";
        $email = "Jack@sprat.com";
        $ethnicity = "Q";
        $race = "X";
        $relationship_to_owner = "self";
        $ssn = "123456789";

        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new PatientProfile($this->BI_USERNAME, $this->BI_PASSWORD);

        $P->setAddress1($address1)
            ->setAddress2($address2)
            ->setCity($city)
            ->setDateOfBirth($date_of_birth)
            ->setDlNumber($dl_number)
            ->setDlState($dl_state)
            ->setEmail($email)
            ->setEthnicity($ethnicity)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setRace($race)
            ->setRelationshipToOwner($relationship_to_owner)
            ->setSsn($ssn)
            ->setState($state)
            ->setZipcode($zipcode);

            # sub assets must be stored as arrays and all fields must be included even if they are not required

            $phone_numbers= [
                [
                    "is_primary" => "1",
                    "phone_type" => "M",
                    "phone_number" => "2125551212"
                ],
                [
                    "is_primary" => "0",
                    "phone_type" => "W",
                    "phone_number" => "2125553434"
                ]

            ];

            $insurances = [[
                "administrator_name" =>"Bob",
                "group_id" =>"123456",
                "employer_name" =>"French Surete",
                "coverage_effective_date" =>"1/1/2021",
                "issuer_id" =>"654321",
                "primary_cardholder" =>"CLOUSEAU, JACQUES",
                "patient_profile_id" =>"123",
                "insurance_type" => 1
                ]];


        $result = $P->setInsurances($insurances)
          ->setPhoneNumbers($phone_numbers)
          ->save();

        exit($result);

    }
    function testGettingSiteProfile(Request $request) {
        $P = new SiteProfile($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        // var_dump($P); exit;
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }

    function testGettingDrugProfile(Request $request) {
        $P = new DrugProfile($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }
    function testGettingQuestionProfile(Request $request) {
        $P = new QuestionProfile($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }
    function testGettingEncounterSchedule(Request $request) {
        $P = new EncounterSchedule($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }
    function testGettingEncounter(Request $request) {
        $P = new Encounter($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }
    function testGettingProcedureResults(Request $request) {
        $P = new ProcedureResults($this->BI_USERNAME,$this->BI_PASSWORD);
        $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq
        $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }
    //By Abb
    function testGettingPatientScheduleSiteQuery(Request $request) {
        // $P = new PatientScheduleSiteQuery('erik.olson@trackmysolutions.us','Mermaid7!!');
        $P = new PatientScheduleSiteQuery($this->BI_USERNAME,$this->BI_PASSWORD);

        $where="SELECT p.asset.*, e.asset.*, s.asset.id as s_id, s.asset.name as name, s.asset.vacinity_name as vacinity_name, s.asset.address1 as site_address1, s.asset.address2 as site_address2, s.asset.city as site_city, s.asset.state as site_state, s.asset.zipcode as site_zipcode, s.asset.county as site_county FROM patient_profile AS p LEFT OUTER JOIN encounter_schedule AS e ON e.asset.patient_id=p.asset.id LEFT OUTER JOIN site_profile AS s ON s.asset.id=e.asset.site_id WHERE (p.asset.first_name ILIKE '%jeff%' OR p.asset.last_name ILIKE '%jeff%')";
        $test = $P->query('patient_profile',$where );

        // $test = $P->array(); // Get an array of rows (arrays with sub objects or sub arrays of sub objects)
        foreach ($test as $row) {
            var_dump($row);
            # edit by querying for 1 result using primary key (id)
            # and then say $Q->setThis($abc)->setThat($xyz)->save();
            # or create a new $Q object and do the same thing. YOU must provide the unique value for id
            # (see below for how I will solve that)
        }
        exit;
    }


    function testUpsertingPatients(Request $request) {

        $pats = file_get_contents('../patients.csv');

        $lines = explode("\n", $pats);

        $once = true;

        foreach ($lines as $line) {

            if (empty($line)) {
                return;
            }

            $row = str_getcsv($line);

            if ($once) {
                $once = false;
                continue;
            }

            $this->upsertPatient($row);

        }
    }

    function upsertPatient($row) {

        $id = 0;

        $ctr = 0;

        $id = $row[$ctr++];
        $email = $row[$ctr++];
        $relationship_to_owner = $row[$ctr++];
        $first_name = $row[$ctr++];
        $last_name = $row[$ctr++];
        $birth_sex = $row[$ctr++];
        $date_of_birth = $row[$ctr++];
        $address1 = $row[$ctr++];
        $address2 = $row[$ctr++];
        $city = $row[$ctr++];
        $state = $row[$ctr++];
        $zipcode = $row[$ctr++];
        $ssn = $row[$ctr++];
        $dl_state = $row[$ctr++];
        $dl_number = $row[$ctr++];
        $ethnicity = $row[$ctr++];
        $race = $row[$ctr++];

        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new PatientProfile($this->BI_USERNAME, $this->BI_PASSWORD);

        $P->setAddress1($address1)
            ->setAddress2($address2)
            ->setCity($city)
            ->setDateOfBirth($date_of_birth)
            ->setDlNumber($dl_number)
            ->setDlState($dl_state)
            ->setEmail($email)
            ->setBirthSex($birth_sex)
            ->setEthnicity($ethnicity)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setRace($race)
            ->setRelationshipToOwner($relationship_to_owner)
            ->setSsn($ssn)
            ->setState($state)
            ->setZipcode($zipcode)
            ->setId($id);

        # sub assets must be stored as arrays and all fields must be included even if they are not required

        $phone_number = $row[$ctr++];

        $phone_numbers= [
            [
                "is_primary" => "1",
                "phone_type" => "M",
                "phone_number" => $phone_number
            ],
            [
                "is_primary" => "0",
                "phone_type" => "W",
                "phone_number" => "8002822882"
            ]

        ];

        $insurances = [[
            "administrator_name" =>"Bo Snerdley",
            "group_id" =>"123456",
            "employer_name" =>"EIB Network",
            "coverage_effective_date" =>"1/1/2021",
            "issuer_id" =>"654321",
            "primary_cardholder" =>"$last_name, $first_name",
            "patient_profile_id" =>"$id",
            "insurance_type" => 1
        ]];


        $result = $P->setInsurances($insurances)
            ->setPhoneNumbers($phone_numbers)
            ->save();

        echo("<pre>$result</pre>");

    }

    function testUpsertingProviders(Request $request) {

        $pats = file_get_contents('../providers.csv');

        $lines = explode("\n", $pats);

        $once = true;

        foreach ($lines as $line) {

            if (empty($line)) {
                return;
            }

            $row = str_getcsv($line);

            if ($once) {
                $once = false;
                continue;
            }

            $this->upsertProvider($row);

        }
    }

    function upsertProvider($row) {

        $id = 0;

        $ctr = 0;

        $id = $row[$ctr++];
        $is_doctor = $row[$ctr++];
        $is_nurse = $row[$ctr++];
        $is_nurse_practioner = $row[$ctr++];
        $npi = $row[$ctr++];
        $sites = $row[$ctr++];

        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new ProviderProfile($this->BI_USERNAME, $this->BI_PASSWORD);

        $result = $P->setIsDoctor($is_doctor)
                ->setIsNurse($is_nurse)
                ->setIsNursePractitioner($is_nurse_practioner)
                ->setNpi($npi)
                ->setId($id)
                ->setSites(json_decode("[1,2,3]"))
                ->setUserId(1)
                ->save();

        echo("<pre>$result</pre>");

    }
    function testUpsertingSites(Request $request) {

        $pats = file_get_contents('../sites.csv');

        $lines = explode("\n", $pats);

        $once = true;

        foreach ($lines as $line) {

            if (empty($line)) {
                return;
            }

            $row = str_getcsv($line);

            if ($once) {
                $once = false;
                continue;
            }

            $this->upsertSite($row);

        }
    }

    function upsertSite($row) {

        $id = 0;

        $ctr = 0;

        $id = $row[$ctr++];
        $name = $row[$ctr++];
        $vacinity_name = $row[$ctr++];
        $address1 = $row[$ctr++];
        $address2 = $row[$ctr++];
        $city = $row[$ctr++];
        $state = $row[$ctr++];
        $zipcode = $row[$ctr++];
        $county = $row[$ctr++];


        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new SiteProfile($this->BI_USERNAME, $this->BI_PASSWORD);

        $result = $P->setAddress1($address1)
            ->setAddress2($address2)
            ->setCity($city)
            ->setVacinityName($vacinity_name)
            ->setCounty($county)
            ->setName($name)
            ->setState($state)
            ->setZipcode($zipcode)
            ->setId($id)
            ->save();

        echo("<pre>$result</pre>");

    }
    function testUpsertingSchedules(Request $request) {

        $pats = file_get_contents('../encounter_schedule.csv');

        $lines = explode("\n", $pats);

        $once = true;

        foreach ($lines as $line) {

            if (empty($line)) {
                return;
            }


            $row = str_getcsv($line);

            if ($once) {
                $once = false;
                continue;
            }

            $this->upsertSchedule($row);

        }
    }

    function upsertSchedule($row) {

        $id = 0;

        $ctr = 0;

        $id = $row[$ctr++];
        $appointment_type = $row[$ctr++];
        $is_walkin = $row[$ctr++];
        $scheduled_time = $row[$ctr++];
        $question_id1 = $row[$ctr++];
        $patient_response1 = $row[$ctr++];
        $question_id2 = $row[$ctr++];
        $patient_response2 = $row[$ctr++];
        $question_id3 = $row[$ctr++];
        $patient_response3 = $row[$ctr++];
        $question_id4 = $row[$ctr++];
        $patient_response4 = $row[$ctr++];
        $patient_id = $row[$ctr++];
        $site_id = $row[$ctr++];
        $provider_id = $row[$ctr++];
        $type = $row[$ctr++];
        $description = $row[$ctr++];
        $scheduled = $row[$ctr++];
        $acknowledged = $row[$ctr++];

        $questions = [
            [ 'question_id' => $question_id1, 'patient_response' => $patient_response1 ],
            [ 'question_id' => $question_id2, 'patient_response' => $patient_response2 ],
            [ 'question_id' => $question_id3, 'patient_response' => $patient_response3 ],
            [ 'question_id' => $question_id4, 'patient_response' => $patient_response4 ]
        ];

        $reminder = [
            'type' => $type,
            'description' => $description,
            'scheduled' => $scheduled,
            'acknowledged' => $acknowledged
        ];

        # instantiate a BurstIq class with optional username & password or use login() method later

        $P = new EncounterSchedule($this->BI_USERNAME, $this->BI_PASSWORD);

        $result = $P->setAppointmentType($appointment_type)
            ->setIsWalkin($is_walkin)
            ->setScheduledTime($scheduled_time)
            ->setSiteId($site_id)
            ->setPatientId($patient_id)
            ->setProviderId($provider_id)
            ->setPatientQuestionResponses($questions)
            ->setReminder($reminder)
            ->setId($id)
            ->save();

        echo("<pre>$result</pre>");

    }


}
