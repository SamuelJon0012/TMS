<?php

namespace App\Http\Controllers;

use App\Encounter;
use App\PatientProfile;
use App\ProcedureResults;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function result() {
//        if ($check !== "positive" && $check !== "negative")
//            return abort(404);

        $test = new Encounter();
        $testResult = $test->find('where asset.type = 0');

        $result = [];
        if ($testResult->data->records) {
            foreach ($testResult->data->records as $data) {
                $patient_id = $data->asset->patient_id;
                if ($data->asset->procedures) {
                    foreach ($data->asset->procedures as $procedure) {
                        $obj = new ProcedureResults();
                        $procedureResult = $obj->find('where `asset.patient_id` = ' . $patient_id);

                        if ($procedureResult->data->records) {
                            foreach ($procedureResult->data->records as $pr) {
                                $result[$patient_id]["result"] = $pr->asset->result;

                                $encounter = new Encounter();
                                $encounter = $encounter->find('where asset.id = ' . $pr->asset->encounter_id);
                                $result[$patient_id]["date_time"] = Carbon::make(get_object_vars($encounter->getDatetime())['$date'])->format('m/d/Y');
                                $result[$patient_id]["expiration_datetime"] = Carbon::make(get_object_vars($pr->asset->expiration_datetime)['$date'])->format('m/d/Y H:i:s');
                                $result[$patient_id]["description"] = $encounter->getProcedures()[0]->description;
                            }
                        }
                    }
                }
            }
        }


//        $positive = false;
//        $negative = false;
//        if ($check === "positive")
//            $positive = true;
//        else
//            $negative = true;

        return view('results', compact('result'));
    }

}
