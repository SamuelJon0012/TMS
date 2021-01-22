<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\PatientProfile;
use App\ProviderProfile;
use Illuminate\Http\Request;

class BurstIqTestController extends Controller
{
    // Ajax Endpoints for BurstIq IO

    function status() {

        $B = new BurstIq();

        return $B->status();
    }

    function login(Request $request) {

        $B = new BurstIq();

        return $B->login('erik.olson@trackmysolutions.us','Mermaid7!!');
    }

    function testGettingAChain(Request $request) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $A = '';

        $B = new BurstIq('erik.olson@trackmysolutions.us','Mermaid7!!');

        $A .= "\n\n" . $B->query('patient_profile',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('provider_profile',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('site_profile',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('drug_profile',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('question_profile',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('encounter_schedule',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('encounter',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('procedure_results',"WHERE asset.id >= 0");
        $A .= "\n\n" . $B->query('user',"WHERE asset.id >= 0");

        exit("<textarea style='width:100%;height:600px;'>$A</textarea>");



    }

    function testGettingAPatient(Request $request) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $P = new ProviderProfile('erik.olson@trackmysolutions.us','Mermaid7!!');

        $test = $P->find("WHERE asset.id >= 0")->getData(); // full object returned from BurstIq

        //$test = $P->get(); // IDK what's up with this, removing for now

        $test = $P->array(); // Get an array of rows (arrays with sub ojects or sub arrays of sub objects)

        foreach ($test as $row) {

            #echo $row['first_name'] . ' ' . $row['last_name'] . '<br/>';
            echo $row['npi'] . '<br/>';

            $P->find("WHERE asset.id = {$row['id']}");

            $P->setNPI('Loretta')->save();

            exit;

        }


        exit;

    }

    function testGettingAProvider(Request $request) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $P = new ProviderProfile('erik.olson@trackmysolutions.us','Mermaid7!!');

        return $P->find("WHERE asset.id >= 0");
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

        $P = new PatientProfile('erik.olson@trackmysolutions.us', 'Mermaid7!!');

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


}
