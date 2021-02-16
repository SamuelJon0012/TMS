<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class PatientCOVIDTestController extends Controller
{
    public function index(Request $req){
        //todo maybe
    }

    public function show($id){
        //todo
    }

    public function insert(Request $req){
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
        //\error_log(json_encode($data,JSON_PRETTY_PRINT)); 

        $encounter = new \App\Encounter();
        
        //TODO populate with real values
        /*
        $encounter
            ->setPatientId(123)
            ->setSiteId(123)
            ->setProviderId(123)
            ->setDatetime(now())
            ->setDxIcd10(123)
            ->setReferingProviderId(123)
            ->setPatientQuestionResponses([
                [
                    'question_id'=>123,
                    'patient_response'=>'something'
                ],
                [
                    'question_id'=>124,
                    'patient_response'=>'something else'
                ]
            ])
            ->setBillingProviderId(123)
            ->setProcedures(null);
        */
        
        //TODO Store the data
        //$encounter->...;

        return $data;
    }

    public function update(Request $req){
        //todo maybe
    }

    public function delete(Request $req, $id){
        //todo maybe
    }
}
