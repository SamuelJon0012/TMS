<?php

namespace App\Http\Controllers;

use App\Encounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PatientProfile;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\Barcode;
use App\SiteProfile;
use App\UserData;
use Exception;

class BarcodeController extends Controller
{

    public function __construct() {
        $this->middleware("auth");
    }

    public function scan() {
        return view("scan-barcode");
    }

    public function getUserInformation(Request $request) { 
        
        if (!$patient_id = (int)request('barcode'))
            return view("scan-barcode")->withErrors(['error'=> 'Invalid barcode']);

        $patient = new PatientProfile();
        if (!$patient->load($patient_id))
            return view("scan-barcode")->withErrors(['error'=> 'Patient not found']);

            
        //Re-format for the page
        $userInfo = (object)$patient->array()[0];
        $userInfo->date_of_birth = $patient->getDateOfBirthText();
        $userInfo->phone_number = $patient->getPrimaryPhoneNumber();
        $userInfo->birth_sex = $patient->getBirthSexByIndex($patient->getBirthSex());
        $userInfo->race = $patient->getRaceByIndex($patient->getRace());
        
        return view("user-info", [
            'userInfo'=>$userInfo,
            'barcode'=>request('barcode'),
        ]);
    }

    public function generateBarcodeImage(Request $request) {
        if (!$user = Auth::user())
            abort(401, 'Please login');

        if (!$patient_id = (int)request('barcode'))
            abort(404, 'Invalid barcode');

        $customerProductId = env('CUSTOMER_PRODUCT_ID','2');

        if ($site_id = $user->site_id){
            //Get the default site ID if the provider has not selected one
            $site = new SiteProfile();
            $site->find("where asset.customer_product_id = $customerProductId");
            $sites = $site->array();
            if (empty($sites))
                throw new Exception('Failed to obtain the site_profile');
            if (count($sites) > 1)
                throw new Exception('Expecting only one site profile for this customer');
        }
            
        $bcCustomerProductId = str_pad($customerProductId, 5, '0', STR_PAD_LEFT);
        $bcSiteId = str_pad($site_id, 5, '0', STR_PAD_LEFT);
        $bcPatientId = str_pad($patient_id, 8, '0', STR_PAD_LEFT);
        
        $barcode = "$bcCustomerProductId-$bcSiteId-$bcPatientId";

        //Get details of the previous encounter
        $userData = new UserData();
        if ($last = json_decode($userData->read($patient_id, UserData::DataType_Last_Rapid_Antigen)))
            $lastTS = ($last->barcode == $barcode) ? ($last->time_stamp ?? 0) : 0;
        else
            $lastTS = 0;

        
        if ($lastTS < strtotime('-2 hours')){ 
            $procedure = [
                'id' => 1,
                'rendering_provider_id' => $user->id,
                'vendor' => 'BD Synapsys',
                'test_type'=> 5,
                'description' => 'BD Veritor System for Rapid Detection of SARS CoV-2 Ag',
            ];
            $encounter = new Encounter();                         //$encounter->curlLogFileName = storage_path('logs/encounter.log');
            $encounter
                ->setId($encounter->nextId())
                ->setPatientId($patient_id)
                ->setSiteId($site_id)
                ->setProviderId($user->id)
                ->setDatetime(date('Y-m-d H:i:s'))
                ->setType(Encounter::EncounterType_COVIDTest)
                ->setPatientQuestionResponses([])
                ->setProcedures([(object)$procedure])
                ->setCustomerProductId($customerProductId)
                ->save();
            $userData->write($patient_id, UserData::DataType_Last_Rapid_Antigen, ['barcode'=>$barcode,'time_stamp'=>time()]);
        }
        
        return view("barcode-image", compact('barcode', 'bcPatientId', 'bcCustomerProductId', 'bcSiteId'));
    }


    public function generateBarcodeImageCovidTest(Request $request) {
        if (!$user = Auth::user())
            abort(401, 'Please login');
            
            if (!$patient_id = (int)request('barcode'))
                abort(404, 'Invalid barcode');
                
                $bcCustomerProductId = str_pad(7, 5, '0', STR_PAD_LEFT); //TODO: get real value
                $bcSiteId = str_pad($user->site_id, 5, '0', STR_PAD_LEFT);
                $bcPatientId = str_pad($patient_id, 8, '0', STR_PAD_LEFT);
                
                $barcode = "$bcCustomerProductId-$bcSiteId-$bcPatientId";
                
                return $barcode;
    }
    
}