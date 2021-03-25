<?php

namespace App\Http\Controllers;

use App\Encounter;
use App\ProcedureResults;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function result() {
//        if ($check !== "positive" && $check !== "negative")
//            return abort(404);

        $obj = new \App\ProcedureResults();
        $procedureResult = $obj->find('where asset.id = 1');
        $procedureResult = $procedureResult->getData()->records[0]->asset->result;

        $encounter = new Encounter();
        $encounter = $encounter->find('where asset.id = 140000');
        $dateTime = Carbon::make(get_object_vars($encounter->getDatetime())['$date'])->format('d/m/Y');
        $encounterDescription = $encounter->getProcedures()[0]->description;

        $result = [
          'result'          => $procedureResult,
          'date_time'       => $dateTime,
          'description'     => $encounterDescription,
          'expiration_date' => ''
        ];

//        $positive = false;
//        $negative = false;
//        if ($check === "positive")
//            $positive = true;
//        else
//            $negative = true;

        return view('results', compact('result'));
    }

}
