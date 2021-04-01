<?php

namespace App\Http\Controllers;

use App\Encounter;
use App\ProcedureResults;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    public function result() {        
        $obj = new \App\ProcedureResults();        
        $user = Auth::user();

        $obj->find('where asset.patient_id = '.$user->id);
        if(!isset($obj->getData()->records[0])){
            $result = [
                'status'  => 'error',
                'msg'     => 'No applicable Lab Tests were found'
            ];
            return view('results', compact('result'));
            
        }
        
        $result = [];
        
        for($ii = 0; $ii < count($obj->data->records); $ii++)
        {
            $date= '$date';
            $encounter = new Encounter();
            $encounter = $encounter->find('where asset.id = '.$obj->data->records[$ii]->asset->encounter_id);

            $dateTime = Carbon::make(get_object_vars($encounter->getDatetime())[$date])->format('d/m/Y');
            $encounterDescription = $encounter->getProcedures()[0]->description;
            
            $procedureResult = $obj->getData()->records[$ii]->asset->result;
            $expirationDate = date("m/d/Y H:i:s a", strtotime(($obj->data->records[$ii]->asset->expiration_datetime->$date)));
            
            $result[] = [
                'result'          => $procedureResult,
                'date_time'       => $dateTime,
                'description'     => $encounterDescription,
                'expiration_date' => $expirationDate
            ];
            
        }

        array_multisort( array_column($result, "expiration_date"), SORT_DESC, $result );

        return view('results', compact('result'));
    }

}