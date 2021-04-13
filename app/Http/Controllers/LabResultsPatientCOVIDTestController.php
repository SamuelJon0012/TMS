<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\Encounter;
use App\PatientProfile;
use App\SiteProfile;
use Illuminate\Http\Request;
use Validator;
use App\UserData;
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



        return ['success'=>true];
    }

    public function myLabResults() {
        $user = Auth::user();
        $Q = "KKS@gmpail.com";

        $P = new PatientProfile();
        $where = "WHERE asset.email = '$Q'";

        if (!$P->find($where)) {

            return $this->error('Search produced an error');

        }

        $data = $this->success($P->array());

        return view("myLabResults", compact('data'));
    }

    private function success($data)
    {

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
