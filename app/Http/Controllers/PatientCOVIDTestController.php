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
        //\error_log(json_encode($req->all(),JSON_PRETTY_PRINT)); 
        $req->validate([
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

        //TODO Store the data

        return $req->all();
    }

    public function update(Request $req){
        //todo maybe
    }

    public function delete(Request $req, $id){
        //todo maybe
    }
}
