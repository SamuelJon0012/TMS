<?php

namespace App\Http\Controllers;

use Auth;
use App\patientVaccine;
use Illuminate\Http\Request;

class PatientVaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return("This is Index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('addvaccine');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'vaccine_name'=>'required',
            'dose_number'=>'required',
            'lot_number'=>'required',
            'manufacturer'=>'required',
            'dose_date'=>'required'
        ]);

        $patientVaccine = new patientVaccine([
            'patient_id' => Auth::id(),
            'name' => $request->get('name'),
            'vaccine_name' => $request->get('vaccine_name'),
            'dose_number' => $request->get('dose_number'),
            'lot_number' => $request->get('lot_number'),
            'manufacturer' => $request->get('manufacturer'),
            'dose_date' => $request->get('dose_date'),
            'health_pro' => $request->get('health_pro')
        ]);
        //dd($patientVaccine);
        $patientVaccine->save();
        return redirect('/home')->with('success', 'Vacccine saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\patientVaccine  $patientVaccine
     * @return \Illuminate\Http\Response
     */
    public function show(patientVaccine $patientVaccine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\patientVaccine  $patientVaccine
     * @return \Illuminate\Http\Response
     */
    public function edit(patientVaccine $patientVaccine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\patientVaccine  $patientVaccine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, patientVaccine $patientVaccine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\patientVaccine  $patientVaccine
     * @return \Illuminate\Http\Response
     */
    public function destroy(patientVaccine $patientVaccine)
    {
        //
    }
}
