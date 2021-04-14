<?php

namespace App\Http\Controllers;

use App\BurstIq;
use App\Encounter;
use App\PatientProfile;
use App\ProcedureResults;
use App\SiteProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\UserData;
use Illuminate\Support\Facades\Auth;
use PDF;
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

        $results = $this->getTestResults($user);

        if ($results) {
            $results = $this->success($results);
        }

        return view("myLabResults", compact('results'));
    }

    private function success($data) {
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function getTestResults($user) {
        $Q = "GirlTest@gmail.com";
//        $Q = $user->email;

        $P = new PatientProfile();
        $where = "WHERE asset.email = '$Q'";

        if (!$P->find($where)) {
            return $this->error('Search produced an error');
        }

        $data = [];

        if ($P->data->records) {
            $obj = new ProcedureResults();
            $id = $P->data->records[0]->asset->id;
            $procedureResult = $obj->find('where `asset.patient_id` = ' . $id);

            if ($procedureResult->data->records) {
                foreach ($procedureResult->data->records as $record) {
                    $asset = $record->asset;
                    $data[] = [
                        'date' => Carbon::make(get_object_vars($record->asset->datetime)['$date'])->format('m/d/Y'),
                        'type' => $record->type,
                        'result' => ucfirst($asset->result),
                        'resultDate' => "Result Date",
                        'resultCorrected' => "Result Corrected",
                    ];
                }
            }
        }

        return $data;
    }

    public function getPdf() {
        $results = $this->getTestResults(auth()->user());
        $pdf = PDF::loadView('pdf', compact('results'), [],
            [
                'title' => 'Test Results - ' . auth()->user()->name,
            ]);
        return $pdf->download('results_' . Carbon::now()->setTimezone('Asia/Riyadh') . '.pdf');
    }
}
