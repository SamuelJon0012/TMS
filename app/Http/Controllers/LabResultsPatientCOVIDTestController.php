<?php

namespace App\Http\Controllers;

use App\Encounter;
use App\SiteProfile;
use Illuminate\Http\Request;
use Validator;
use App\UserData;
use Exception;
use Illuminate\Support\Facades\Auth;
use PDO;

class LabResultsPatientCOVIDTestController extends Controller
{
    public function index(Request $req){
        //todo maybe
    }

    public function show($id){
        //todo
    }

    public function insert(Request $req){
        if (!$user = Auth::user())
            abort(401, 'Please login');

        //TODO get reference number from self-test kid

        $data = $req->validate([
            'isSelfTesting' => ['required', 'boolean'],
            'hasSevereSymptoms' => ['required', 'boolean'],
            'hasCloseContact'=>['required'],
            'wasInfected'=>['required','boolean'],
            'symptoms'=>['required', 'array', 'min:1'],
            'issues'=>['required', 'array' , 'min:1'],
            'phoneMessage'=>['required', 'boolean'],
            'heightFeet'=>['required', 'numeric', 'between:0,20'],
            'heightInch'=>['required', 'numeric', 'between:0,11'],
            'weight'=>['required', 'numeric', 'between:0,2000'],
            'consent'=>['boolean']
        ]);

        //Store the answers
        UserData::write($user->id, UserData::DataType_COVID_Test_Questionare, $data);
        
        $isSelfTesting = $data['isSelfTesting'];
        //die(json_encode($data,JSON_PRETTY_PRINT));

        //Writting to the encounter chain happens after the patient enters the Test Kit Activation Code -OR- when the provider scans the barcode

        return $data;
    }

    public function update(Request $req){
        //todo maybe
    }

    public function delete(Request $req, $id){
        //todo maybe
    }
    
    public function patient_COVID_test_modal (Request $request) {
        if (!$user = Auth::user())
            abort(401, 'Please login');
        if ($user->hasRole('patient')){
            $patient_id = $user->id;
        } else {
            $patient_id = request('patient_id');
        }
        return view ("app.lab_results_patient_COVID_test_modal", compact('patient_id'));
    }

    public function testKit(Request $request){
        if (!$user = Auth::user())
            abort(401, 'Please login');

        $referenceNumber = request('TestKitCode');
        if (empty($referenceNumber))
            abort(400, 'Invalid Test Kit Number');

        $customerProductId = env('CUSTOMER_PRODUCT_ID','2');

        //Get the site ID
        $site = new SiteProfile();
        $site->find("where asset.customer_product_id = $customerProductId");
        $sites = $site->array();
        if (empty($sites))
            throw new Exception('Failed to obtain the site_profile');
        if (count($sites) > 1)
            throw new Exception('Expecting only one site profile for this customer');

        //Get the provider ID
        $providerId = null; // TODO get a real value for this

        //Get the questions
        $userData = new UserData();
        $txt = $userData->read($user->id, UserData::DataType_COVID_Test_Questionare);
        $list = (empty($txt)) ? [] : json_decode($txt, true);
        //TODO: Load these question into the encounter when we know how
        $patient_question_responses = [];
        
        //Build Procedure
        $procedure = [
            'id' => 1,
            'rendering_provider_id' => $providerId,
            'reference_number' => $referenceNumber,
            'vendor' => 'Eurofins',
            'test_type'=> 4,
            'description' => 'Viacor SARS-CoV-2 assay DTC',
        ];

        $encounter = new Encounter();                         //$encounter->curlLogFileName = storage_path('logs/encounter.log');
        $encounter
            ->setId($encounter->nextId())
            ->setPatientId($user->id)
            ->setSiteId($site->getId())
            ->setProviderId($providerId)
            ->setDatetime(date('Y-m-d H:i:s'))
            ->setType(Encounter::EncounterType_COVIDTest)
            ->setPatientQuestionResponses($patient_question_responses)
            ->setProcedures([(object)$procedure])
            ->setCustomerProductId($customerProductId)
            ->save();
        
        return ['success'=>true];
    }
}
